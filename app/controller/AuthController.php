<?php

require_once DAO_PATH . 'UserDAO.php';
require_once UTIL_PATH . 'AuthUtils.php';
require_once UTIL_PATH . 'SessionUtils.php';
require_once MODEL_PATH . 'User.php';
require_once CONTROLLER_PATH . 'UserController.php';

class AuthController
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        SessionUtils::logout();
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
        
        $usrKey = trim($_POST['usrkey'] ?? '');
        $password = $_POST['password'] ?? '';

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
            $msg = implode(' ', $errors);   // Return to the login view the error encountered
            $err = new AppError(422, $msg);
            $data = ['error' => $err];
            $view = 'auth/login.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        // Try to authenticate the user
        $user = AuthUtils::authenticate($usrKey, $password);
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

        SessionUtils::login($user->getId());
        header('Location: ?controller=Product&action=index');
        exit;
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        SessionUtils::logout();
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

        $uc = new UserController();
        $result = $uc->store($_POST, true, 'auth/register.php', '?controller=Auth&action=showLogin&message=registered');

        if (!is_array($result) || empty($result['success'])) {
            $err = $result['error'] ?? new AppError(500, 'Registration failed.');
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
        SessionUtils::logout();
        header('Location: ?controller=Auth&action=showLogin&message=logged_out');
        exit;
    }
}
