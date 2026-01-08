<?php

// Define the base paths
define('BASE_PATH', __DIR__ . '/../');

// ----- General Paths
define('APP_PATH', BASE_PATH . 'app/');
define('DB_PATH', BASE_PATH . 'db/');
define('LOGS_PATH', BASE_PATH . 'logs/');
define('PUBLIC_PATH', BASE_PATH . 'public/');

// ----- APP Paths
define('CONTROLLER_PATH', APP_PATH . 'controller/');
define('VIEW_PATH', APP_PATH . 'view/');
define('MODEL_PATH', APP_PATH . 'model/');
define('DAO_PATH', APP_PATH . 'DAO/');
define('UTIL_PATH', APP_PATH . 'util/');

include_once MODEL_PATH . 'AppError.php';           // Include AppError model globally
include_once UTIL_PATH . 'SessionUtils.php';        // Include SessionUtils globally

// Start session early to avoid "headers already sent" when views call SessionUtils
SessionUtils::ensureStarted();

if (isset($_GET['controller'])) {

    $controllerName = strtolower(trim($_GET['controller']));

    if ($controllerName == "api" && isset($_GET['resource'])) {                                     // API request

        require_once PUBLIC_PATH . "api.php";                                                       // Load the API router

    } elseif ($controllerName == "admin"){                                                         // Admin section reqest

        SessionUtils::requireLogin();                                                             // Require user logged
        SessionUtils::requireAdmin();                                                              // Require admin role
        $action = $_GET['action'] ?? 'index';
        if ($action == 'index') {                                                               // Check admin session
            $view = 'admin/index.html';
        }
        include_once VIEW_PATH . 'main.php';
        
    } else {                                                                                        // Regular request

        $controllerName = ucfirst($controllerName) . 'Controller';
        $controllerFile = CONTROLLER_PATH . $controllerName . ".php";                           // Build controller file path

        if (file_exists($controllerFile)) {                                                         // Load controller file
            require_once $controllerFile;
        } else {
            header('Location: ?controller=Error&action=show&code=404&message=Controller+not+found');
            exit;
        }

        if (class_exists($controllerName)) {                                                        // Instantiate controller and execute action

            $controllerInstance = new $controllerName();
            $action = $_GET['action'] ?? 'index';

            if (isset($action) && method_exists($controllerInstance, $action)) {
                $controllerInstance->$action();
            } else {
                header('Location: ?controller=Error&action=show&code=404&message=Action+not+found');
                exit;
            }
        } else {
            header('Location: ?controller=Error&action=show&code=404&message=Class+not+found');
            exit;
        }
    }
} else {
    header('Location: ?controller=General&action=home');
    exit;
}
