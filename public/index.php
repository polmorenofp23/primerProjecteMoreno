<?php

// Define the base paths
define('BASE_PATH', __DIR__ . '/../');
define('CONTROLLER_BASE_PATH', __DIR__ . '/../app/controller/');

if (isset($_GET['controller'])) {

    $controllerName = trim($_GET['controller']);

    if ($controllerName == "api" && isset($_GET['resource'])) {                                     // API request

        require_once BASE_PATH . "/public/api.php";                                                 // Load the API router

    } else {                                                                                        // Regular request

        $controllerName = ucfirst($controllerName) . 'Controller';                                  // Normalized controller class name   
        $controllerFile = CONTROLLER_BASE_PATH . $controllerName . ".php";                          // Build controller file path

        if (file_exists($controllerFile)) {                                                         // Load controller file
            require_once $controllerFile;
        } else {
            header('Location: 404.html');
            exit;
        }

        if (class_exists($controllerName)) {                                                        // Instantiate controller and execute action

            $controllerInstance = new $controllerName();
            $action = $_GET['action'] ?? 'index';

            if (isset($action) && method_exists($controllerInstance, $action)) {
                $controllerInstance->$action();
            } else {
                header("Location:404.html");
                exit;
            }
        } else {
            header('Location: 404.html');
            exit;
        }
    }
} else {
    echo ("ERROR: The requested controller doesn't exists!");
}
