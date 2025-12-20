<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productes - Bees Cavern</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">

        <h1>Menú de Productes</h1>
        <a href="/">Inici</a>
        <a href="?controller=Product&action=index">Tots els productes</a>

        <main class="products-grid">
            <div class="row g-4">
                <?php if (!empty($products)): ?>
                    <?php include_once VIEW_PATH . 'partials/components/bc-menu-product.php'; ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                            <?php renderBCMenuProduct($product); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-products">
                        <p>No products found for this filter</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!--<script src="/js/product-cart.js"></script>-->
</body>
</html>
