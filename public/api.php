<?php

define('API_CONTROLLER_BASE_PATH', CONTROLLER_BASE_PATH . 'API/');

// CORS y JSON headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle CORS preflight: respond to OPTIONS requests with 204 and stop before controller logic
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Resource & method determination
$resource    = ucfirst($_GET['resource'] ?? 'User'); 
$httpMethod  = $_SERVER['REQUEST_METHOD'];
$id          = $_GET['id'] ?? null;

// Map HTTP verb to controller method
switch ($httpMethod) {
    case 'GET':
        $method = $id ? 'show' : 'index';
        break;
    case 'POST':
        $method = 'store';
        break;
    case 'PUT':
        $method = 'update';
        break;
    case 'PATCH':
        $method = 'update';
        break;
    case 'DELETE':
        $method = 'destroy';
        break;
    default:
        http_response_code(405);
        die(json_encode(['error' => 'HTTP method not allowed']));
}

// Build API controller class name and file path
$controllerName = "API" . $resource . "Controller";
$controllerFile  = API_CONTROLLER_BASE_PATH . $controllerName .".php";

if (file_exists($controllerFile)) { // Load controller file
    require_once $controllerFile;
    
    if (class_exists($controllerName)) { // Instantiate controller and execute method                     
        $controllerInstance = new $controllerName();

        if (method_exists($controllerInstance, $method)) { // Pass ID if applicable
            if ($id && in_array($method, ['show', 'update', 'destroy'], true)) {
                $controllerInstance->$method($id);
            } else {
                $controllerInstance->$method();
            }
        } else {
            http_response_code(404);
            die(json_encode(['error' => "El método '$method' no existe en el controlador '$controllerClass'"]));
        }
    } else {
        http_response_code(404);
        die(json_encode(['error' => "La clase '$controllerName' no existe"]));
    }
} else {
    http_response_code(404);
    die(json_encode(['error' => "El controlador API '$controllerName' no existe"]));
}

exit;