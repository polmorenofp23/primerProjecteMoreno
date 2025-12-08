<?php
/**
 * Generic error view
 * Displays the error information using the `Error` model.
 */

// Prefer a passed Error model; fall back to constructing one from code/message
if (isset($data['error']) && is_object($data['error'])) {
    $errorModel = $data['error'];
} else {
    $code = isset($data['error_code']) ? (int)$data['error_code'] : 404;
    $msg = isset($data['message']) ? $data['message'] : null;
    if (!class_exists('AppError')) {
        include_once APP_PATH . 'model/AppError.php';
    }
    $errorModel = new AppError($code, $msg);
}

$errorCode = $errorModel->getCode();
$errorTitle = $errorModel->getName();
$errorDescription = $errorModel->getDescription();
$customMessage = $errorModel->getMessage();

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
