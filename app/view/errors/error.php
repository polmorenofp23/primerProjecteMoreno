<?php
/**
 * Generic error view
 * Displays the error code and its description
 */

// Error codes and their descriptions
$errorMessages = [
    400 => 'Bad Request - The request cannot be processed due to a client error',
    401 => 'Unauthorized - Authentication is required to access this resource',
    403 => 'Forbidden - You do not have permission to access this resource',
    404 => 'Not Found - The page or resource you are looking for does not exist',
    405 => 'Method Not Allowed - The HTTP method used is not allowed',
    408 => 'Request Timeout - The request took too long to process',
    409 => 'Conflict - There is a conflict with the current state of the resource',
    410 => 'Gone - The resource is no longer available and will not be available again',
    422 => 'Unprocessable Entity - The submitted data is not valid',
    429 => 'Too Many Requests - You have exceeded the request limit',
    500 => 'Internal Server Error - An internal server error occurred',
    501 => 'Not Implemented - Functionality not implemented',
    502 => 'Bad Gateway - Invalid response from the server',
    503 => 'Service Unavailable - The service is temporarily unavailable',
    504 => 'Gateway Timeout - The server did not respond in time'
];

// Get error code (default 404 if not specified)
$errorCode = isset($data['error_code']) ? (int)$data['error_code'] : 404;
$customMessage = isset($data['message']) ? $data['message'] : null;

// Get corresponding error message
$errorMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : 'Unknown Error';

// Separate title from description
$errorParts = explode(' - ', $errorMessage, 2);
$errorTitle = $errorParts[0];
$errorDescription = isset($errorParts[1]) ? $errorParts[1] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?= $errorCode ?> - Bees Cavern</title>
</head>
<body>
    <div>
        <div>ERROR <?= $errorCode ?></div>
        <h1><?= htmlspecialchars($errorTitle) ?></h1>
        <p><?= htmlspecialchars($errorDescription) ?></p>
        
        <?php if ($customMessage): ?>
        <div>
            <?= htmlspecialchars($customMessage) ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
