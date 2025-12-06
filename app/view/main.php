<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bees Cavern Web</title>
    <!--<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>-->
    <!-- css Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <header><?php include_once VIEW_PATH . '/partials/header.php'; ?></header>

    <div class="container">
        <?php 
        if (isset($view) && file_exists($view)) { // Include the specific view that was set by the controller
            include_once $view;
        } else {
            $data = ['error_code' => 404];
            include_once VIEW_PATH . 'errors/error.php';
        }
        ?>
    </div>

    <footer><?php include_once VIEW_PATH . '/partials/footer.php'; ?></footer>

    <!--Javascript Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>
</html>
