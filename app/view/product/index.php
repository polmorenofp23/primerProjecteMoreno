<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu - Bees Cavern</title>
</head>
<body>
    <div class="mx-auto my-4 col-11 col-lg-10">

        <!-- Component Title -->
        <h1>Menú de Productes</h1>
        <a href="/">Inici</a>
        <a href="?controller=Product&action=index">Tots els productes</a>


        <!-- Filter Buttons Options -->

        <main class="products-grid">
            <div class="row g-4">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 d-flex">
                            <?php renderBCProductCard($product); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-products">
                        <p>No products found for these filters</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!--<script src="/js/product-cart.js"></script>-->
</body>
</html>
