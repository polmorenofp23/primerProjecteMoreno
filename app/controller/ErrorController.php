<?php

include_once APP_PATH . 'model/Error.php';

class ErrorController
{
    /**
     * Display error page with error code and optional message
     * Posible parameters: 
     * - code = (default: 404) 
     * - message = (Customized message to add information about the error)
     */
    public function show()
    {
        $errorCode = isset($_GET['code']) ? (int)$_GET['code'] : 404;
        $message = isset($_GET['message']) ? urldecode($_GET['message']) : null;
        $view = VIEW_PATH . 'errors/error.php';

        $error = new Error($errorCode, $message);
        $data = ['error' => $error];

        include_once VIEW_PATH . 'main.php';
    }
}
