<?php

require_once DAO_PATH . 'UserDAO.php';
require_once UTIL_PATH . 'Auth.php';
require_once MODEL_PATH . 'User.php';

class AuthController
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        $view = 'auth/login.php';
        include_once VIEW_PATH . 'main.php';
    }

    /**
     * Handle login POST
     */
    public function doLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=Auth&action=showLogin');
            exit;
        }
        // Read POST (use lowercase names to match the form)
        $usrKey = trim($_POST['usrkey'] ?? '');
        $password = $_POST['password'] ?? '';

        // Server-side validation (inline)
        $errors = [];

        if ($usrKey === '') {
            $errors['usrkey'] = 'Your username or email is required.';
        } else {
            if (strpos($usrKey, '@') !== false && !filter_var($usrKey, FILTER_VALIDATE_EMAIL)) {
                $errors['usrkey'] = 'Please enter a valid email address.';
            }
        }

        if ($password === '') {
            $errors['password'] = 'The Password field is required.';
        }

        if (!empty($errors)) {
            $old = ['usrkey' => $usrKey];
            // Aggregate validation messages into a single AppError for the view
            $msg = implode(' ', $errors);
            $err = new AppError(422, $msg);
            $data = ['error' => $err];
            $view = 'auth/login.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        // Try to authenticate
        $user = Auth::authenticate($usrKey, $password);
        if ($user === null) {
            $dao = new UserDAO();
            $exists = $dao->getUserByUsername($usrKey) || $dao->getUserByEmail($usrKey);
            $old = ['usrkey' => $usrKey];
            $code = $exists ? 401 : 404;
            $msg = $exists ? 'Invalid credentials.' : 'User not found.';
            $err = new AppError($code, $msg);
            $data = ['error' => $err];
            $view = 'auth/login.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        // Successful login: set session and redirect to home
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['user_id'] = $user->getId();

        header('Location: ?controller=Product&action=index');
        exit;
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        $view = 'auth/register.php';
        include_once VIEW_PATH . 'main.php';
    }

    /**
     * Handle registration POST
     */
    public function doRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=Auth&action=showRegister');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? null);
        $birthDay = trim($_POST['birth_day'] ?? '');
        $birthMonth = trim($_POST['birth_month'] ?? '');
        $birthYear = trim($_POST['birth_year'] ?? '');

        $birthDate = null;
        if ($birthYear !== '' || $birthMonth !== '' || $birthDay !== '') {  // Normalize data into date format (YYYY-MM-DD)
            if ($birthYear === '' || $birthMonth === '' || $birthDay === '') {
                $err = new AppError(422, 'Incomplete birth date.');
                $data = ['error' => $err];
                $view = 'auth/register.php';
                include_once VIEW_PATH . 'main.php';
                return;
            }

            $y = (int)$birthYear;
            $m = (int)$birthMonth;
            $d = (int)$birthDay;

            if (!checkdate($m, $d, $y)) {
                $err = new AppError(422, 'Invalid birth date.');
                $data = ['error' => $err];
                $view = 'auth/register.php';
                include_once VIEW_PATH . 'main.php';
                return;
            }

            $birthDate = sprintf('%04d-%02d-%02d', $y, $m, $d);
        }

        $phone = trim($_POST['phone'] ?? null);
        $street = trim($_POST['address_street'] ?? null);
        $city = trim($_POST['address_city'] ?? null);
        $postcode = trim($_POST['address_postcode'] ?? null);
        $country = trim($_POST['address_country'] ?? null);

        // Basic validations
        if ($username === '' || $email === '' || $password === '') {
            $err = new AppError(422, 'Username, email and password are required.');
            $data = ['error' => $err];
            $view = 'auth/register.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        if ($password !== $passwordConfirm) {
            $err = new AppError(422, 'Password confirmation does not match.');
            $data = ['error' => $err];
            $view = 'auth/register.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        $dao = new UserDAO();
        if (Auth::existsByUsername($username)) {
            $err = new AppError(409, 'Username already taken.');
            $data = ['error' => $err];
            $view = 'auth/register.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }
        if (Auth::existsByEmail($email)) {
            $err = new AppError(409, 'Email already registered.');
            $data = ['error' => $err];
            $view = 'auth/register.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        $user = new User();
        $user->setUserTypeId(1);
        $user->setUsername($username);
        $user->setRole('client');
        $user->setEmail($email);
        $user->setFirstName($firstName ?: $username);
        $user->setLastName($lastName ?: null);

        // phone
        $user->setPhone($phone ?: null);

        // address as associative array (UserDAO will encode)
        $address = null;
        if ($street || $city || $postcode || $country) {
            $address = [
                'street' => $street ?: '',
                'city' => $city ?: '',
                'postcode' => $postcode ?: '',
                'country' => $country ?: ''
            ];
            $user->setAddress($address);
        }

        $user->setBirthDate($birthDate ?: null);
        $user->setRegisteredAt(date('Y-m-d H:i:s'));
        $user->setAndHashPassword($password);

        $id = $dao->createUser($user);
        if (!$id) {
            $err = new AppError(500, 'Failed to create user.');
            $data = ['error' => $err];
            $view = 'auth/register.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        header('Location: ?controller=Auth&action=showLogin&message=registered');
        exit;
    }

    /**
     * Logout user
     */
    public function logout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        unset($_SESSION['user_id']);
        session_regenerate_id(true);
        header('Location: ?controller=Auth&action=showLogin&message=logged_out');
        exit;
    }
}
