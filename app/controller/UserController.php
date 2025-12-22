<?php

require_once DAO_PATH . 'UserDAO.php';
require_once MODEL_PATH . 'User.php';
require_once UTIL_PATH . 'AuthUtils.php';
require_once UTIL_PATH . 'SessionUtils.php';

class UserController
{
    /**
     * Show the registration form
     */
    public function create()
    {
       
    }

    /**
     * Store a new user (handle registration user POST)
     */
    public function store(array $input = null, bool $returnResult = false, string $fromView = 'auth/register.php', string $successRedirect = '?controller=Auth&action=showLogin&message=registered')
    {
        $data = $input ?? $_POST;

        if ($input === null && ($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            header('Location: ?controller=User&action=create');
            exit;
        }

        // Validate input using the shared validator
        $validation = self::validateUserData($data, false, null);
        if (!$validation['success']) {
            $err = $validation['error'];
            if ($returnResult) return ['success' => false, 'error' => $err];
            $dataOut = ['error' => $err];
            $view = $fromView;
            include_once VIEW_PATH . 'main.php';
            return;
        }

        $userDataValidated = $validation['data'];

        $dao = new UserDAO();

        $user = new User();
        $user->setUserTypeId(1);
        $user->setUsername($userDataValidated['username']);
        $user->setRole('client');
        $user->setEmail($userDataValidated['email']);
        $user->setFirstName($userDataValidated['first_name'] ?: $userDataValidated['username']);
        $user->setLastName($userDataValidated['last_name'] ?: null);
        $user->setPhone($userDataValidated['phone'] ?: null);

        if ($userDataValidated['address']) {
            $user->setAddress($userDataValidated['address']);
        }

        $user->setBirthDate($userDataValidated['birth_date'] ?: null);
        $user->setRegisteredAt(date('Y-m-d H:i:s'));
        $user->setAndHashPassword($userDataValidated['password']);

        $id = $dao->createUser($user, $userDataValidated['password']);
        if (!$id) {
            $err = new AppError(500, 'Failed to create user.');
            if ($returnResult) return ['success' => false, 'error' => $err];
            $dataOut = ['error' => $err];
            $view = $fromView;
            include_once VIEW_PATH . 'main.php';
            return;
        }

        if ($returnResult) return ['success' => true, 'id' => $id, 'user' => $user];

        header('Location: ' . $successRedirect);
        exit;
    }

    /**
     * Show the form of user profile to edit its data
     */
    public function edit()
    {
        SessionUtils::requireLogin();

        $currentId = SessionUtils::getUserId();
        if (!$currentId) {
            header('Location: ?controller=Auth&action=showLogin');
            exit;
        }

        $dao = new UserDAO();
        $user = $dao->getUserById($currentId);
        if (!$user) {
            header('Location: ?controller=Error&action=show&code=404&message=User+not+found');
            exit;
        }

        $data = ['user' => $user];
        $view = 'user/profile.php';
        include_once VIEW_PATH . 'main.php';
    }

    /**
     * Handle a put of a user edit form
     */
    public function update()
    {
        SessionUtils::requireLogin();
        $currentId = SessionUtils::getUserId();
        $id = isset($_POST['id']) ? (int)$_POST['id'] : $currentId;

        if (!$id) {
            header('Location: ?controller=Error&action=show&code=400&message=User+id+missing');
            exit;
        }

        $dao = new UserDAO();
        $user = $dao->getUserById($id);
        if (!$user) {
            header('Location: ?controller=Error&action=show&code=404&message=User+not+found');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=User&action=edit');
            exit;
        }

        $validation = self::validateUserData($_POST, true, $id);
        if (!$validation['success']) {
            $err = $validation['error'];
            $dataOut = ['error' => $err];
            $view = 'user/edit.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        $userDataValidated = $validation['data'];
        if ($userDataValidated['username']) $user->setUsername($userDataValidated['username']);
        if ($userDataValidated['email']) $user->setEmail($userDataValidated['email']);
        if ($userDataValidated['first_name']) $user->setFirstName($userDataValidated['first_name']);
        if ($userDataValidated['last_name']) $user->setLastName($userDataValidated['last_name']);
        if ($userDataValidated['phone'] !== null) $user->setPhone($userDataValidated['phone']);
        if ($userDataValidated['address'] !== null) $user->setAddress($userDataValidated['address']);
        if ($userDataValidated['birth_date'] !== null) $user->setBirthDate($userDataValidated['birth_date']);
        if ($userDataValidated['password']) {
            $user->setAndHashPassword($userDataValidated['password']);
        }

        $ok = $dao->updateUser($user);
        if (!$ok) {
            $err = new AppError(500, 'Failed to update user');
            $data = ['user' => $user, 'error' => $err];
            $view = 'user/profile.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        SessionUtils::setFlashHttpResponse(200, 'User successfully updated');
        header('Location: ?controller=User&action=edit');
        exit;
    }

    /**
     * Validate user input for store and update operations.
     * Returns ['success' => true, 'data' => cleanedData] or ['success' => false, 'error' => AppError]
     */
    private static function validateUserData(array $data, bool $isUpdate = false, ?int $excludeUserId = null): array
    {
        $username = trim($data['username'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? null;
        $passwordConfirm = $data['password_confirm'] ?? null;
        $firstName = trim($data['first_name'] ?? '');
        $lastName = trim($data['last_name'] ?? '');
        $birthDay = trim($data['birth_day'] ?? '');
        $birthMonth = trim($data['birth_month'] ?? '');
        $birthYear = trim($data['birth_year'] ?? '');

        $birthDate = null;
        if ($birthYear !== '' || $birthMonth !== '' || $birthDay !== '') {
            if ($birthYear === '' || $birthMonth === '' || $birthDay === '') {
                return ['success' => false, 'error' => new AppError(422, 'Incomplete birth date.')];
            }
            $y = (int)$birthYear;
            $m = (int)$birthMonth;
            $d = (int)$birthDay;
            if (!checkdate($m, $d, $y)) {
                return ['success' => false, 'error' => new AppError(422, 'Invalid birth date.')];
            }
            $birthDate = sprintf('%04d-%02d-%02d', $y, $m, $d);
        }

        $phone = trim($data['phone'] ?? '');
        $street = trim($data['address_street'] ?? '');
        $city = trim($data['address_city'] ?? '');
        $postcode = trim($data['address_postcode'] ?? '');
        $country = trim($data['address_country'] ?? '');

        if (!$isUpdate) {
            if ($username === '' || $email === '' || empty($password)) {
                return ['success' => false, 'error' => new AppError(422, 'Username, email and password are required.')];
            }
        }

        if (!empty($password) && $password !== $passwordConfirm) {
            return ['success' => false, 'error' => new AppError(422, 'Password confirmation does not match.')];
        }

        $dao = new UserDAO();
        if ($username !== '') {
            $u = $dao->getUserByUsername($username);
            if ($u && $u->getId() !== $excludeUserId) {
                return ['success' => false, 'error' => new AppError(409, 'Username already taken.')];
            }
        }
        if ($email !== '') {
            $e = $dao->getUserByEmail($email);
            if ($e && $e->getId() !== $excludeUserId) {
                return ['success' => false, 'error' => new AppError(409, 'Email already registered.')];
            }
        }

        $address = null;
        if ($street || $city || $postcode || $country) {
            $address = [
                'street' => $street ?: '',
                'city' => $city ?: '',
                'postcode' => $postcode ?: '',
                'country' => $country ?: ''
            ];
        }

        $userDataValidated = [
            'username' => $username ?: null,
            'email' => $email ?: null,
            'password' => $password ?: null,
            'first_name' => $firstName ?: null,
            'last_name' => $lastName ?: null,
            'birth_date' => $birthDate ?: null,
            'phone' => $phone ?: null,
            'address' => $address,
        ];

        return ['success' => true, 'data' => $userDataValidated];
    }
}
