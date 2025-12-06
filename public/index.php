<?php

// Define the base paths
define('BASE_PATH', __DIR__ . '/../');

// ----- General Paths
define('APP_PATH', BASE_PATH . 'app/');
define('DB_PATH', BASE_PATH . 'db/');
define('LOGS_PATH', BASE_PATH . 'logs/');
define('PUBLIC_PATH', BASE_PATH . 'public/');

// ----- APP Paths
define('CONTROLLER_BASE_PATH', APP_PATH . 'controller/');
define('VIEW_PATH', APP_PATH . 'view/');
define('MODEL_PATH', APP_PATH . 'model/');
define('DAO_PATH', APP_PATH . 'DAO/');
define('UTIL_PATH', APP_PATH . 'util/');


if (isset($_GET['controller'])) {

    $controllerName = trim($_GET['controller']);

    if ($controllerName == "api" && isset($_GET['resource'])) {                                     // API request

        require_once PUBLIC_PATH . "api.php";                                                       // Load the API router

    } else {                                                                                        // Regular request

        $controllerName = ucfirst($controllerName) . 'Controller';
        $controllerFile = CONTROLLER_BASE_PATH . $controllerName . ".php";                          // Build controller file path

        if (file_exists($controllerFile)) {                                                         // Load controller file
            require_once $controllerFile;
        } else {
            header('Location: ?controller=Error&code=404&message=Controller+not+found');
            exit;
        }

        if (class_exists($controllerName)) {                                                        // Instantiate controller and execute action

            $controllerInstance = new $controllerName();
            $action = $_GET['action'] ?? 'index';

            if (isset($action) && method_exists($controllerInstance, $action)) {
                $controllerInstance->$action();
            } else {
                header('Location: ?controller=Error&code=404&message=Action+not+found');
                exit;
            }
        } else {
            // Class not found - show error view with main layout
            header('Location: ?controller=Error&code=404&message=Class+not+found');
            exit;
        }
    }
} else {
    // No controller specified - show error view with main layout
    header('Location: ?controller=Error&code=400&message=Controller+parameter+is+missing');
    exit;
}
