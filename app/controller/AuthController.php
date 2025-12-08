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

        $usrKey = trim($_POST['usrKey'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($usrKey === '' || $password === '') {
            $error = new Error(400, 'Username or email and password are required.');
            $data = ['error' => $error];
            $view = 'auth/login.php';
            include_once VIEW_PATH . 'main.php';
            return;
        }

        $user = Auth::authenticate($usrKey, $password);
        if ($user === null) {
            // Determine if user exists to provide a better error code
            $dao = new UserDAO();
            $exists = $dao->getUserByUsername($usrKey) || $dao->getUserByEmail($usrKey);
            $err = $exists ? new Error(401, 'Invalid credentials.') : new Error(404, 'User not found.');
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

        // Make a basic validation thajt the user doesn't match with any existing user
        if ($username === '' || $email === '' || $password === '') {
            $err = new AppError(422, 'Username, email and password are required.');
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
        $user->setFirstName($username);
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

        // Registration successful - redirect to login with a success message
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
