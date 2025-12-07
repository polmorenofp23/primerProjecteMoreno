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
            // Fallback: show a 404 error using the Error model
            if (!class_exists('Error')) {
                include_once APP_PATH . 'model/Error.php';
            }
            $error = new Error(404);
            $data = ['error' => $error];
            include_once VIEW_PATH . 'errors/error.php';
        }
        ?>
    </div>

    <footer><?php include_once VIEW_PATH . '/partials/footer.php'; ?></footer>

    <!--Javascript Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" 
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" 
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" 
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" 
        crossorigin="anonymous">
    </script>
</body>
</html>
