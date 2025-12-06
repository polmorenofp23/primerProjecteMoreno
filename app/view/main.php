<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bees Cavern Web</title>
    <link rel="stylesheet" href="/public/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <header><?php include_once VIEW_PATH . '/partials/header.php'; ?></header>

    <div class="container">
        <?php 
        // Include the specific view that was set by the controller
        if (isset($view) && file_exists($view)) {
            include_once $view;
        } else {
            $data = ['error_code' => 404];
            include_once VIEW_PATH . 'errors/error.php';
        }
        ?>
    </div>

    <footer><?php include_once VIEW_PATH . '/partials/footer.php'; ?></footer>

</body>
</html>
