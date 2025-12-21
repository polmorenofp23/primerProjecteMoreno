<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu - Bees Cavern</title>
</head>
<body>
    <div class="d-flex flex-column justify-content-center align-items-center col-12">
        <div class="d-flex flex-column flex-md-row justify-content-between justify-content-md-center align-items-center col-12 my-4 ">
            <div class="col-12 col-md-9 mb-md-4">
                <?php renderBCPageTitle([ 'Menu' => '/?controller=Product&action=index', 'Main Plates' => null,]); ?>
            </div>
            <div class="col-6 col-md-3 pe-3"> <!-- Not operative, si hay tiempo ya lo implementare -->
                <input class="w-100 text-primary-red" type="text" placeholder="Search By Product Name or Id">
                    <i data-lucide="search" class="icon-red"></i>
                </input>
            </div>
        </div>
        <!-- Filter Buttons Options -->
        <filter class="col-12 my-3">    </filter>
    </div>
    <div class="mx-auto my-4 col-11 col-lg-10">
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
