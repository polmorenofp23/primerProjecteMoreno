<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu - Bees Cavern</title>
    <style>
        /* Use the element's text color for placeholder and make sure it's visible */
        input.text-primary-red::placeholder { color: currentColor; opacity: 1; }
        
    </style>
</head>
<body>
    <div class="d-flex flex-column justify-content-center align-items-center col-12">
        <div class="d-flex flex-column flex-md-row justify-content-between justify-content-md-center align-items-center col-12 my-4 ">
            <div class="col-12 col-md-9 mb-md-4">
                <?php renderBCPageTitle([ 'Menu' => '/?controller=Product&action=index', 'Main Plates' => null,]); ?>
            </div>
            <div class="col-6 col-md-3 pe-5"> <!-- Search form: submits GET to Product index with ?identifierSearch=... -->
                <form action="/?controller=Product&action=index" method="get" class="w-100">
                    <div class="input-group rounded-0 text-primary-red">
                        <input name="identifierSearch" class="form-control text-primary-red border-primary-red rounded-0" type="search" 
                            placeholder="Search Product by Name or Id" aria-label="Search products">
                        <button class="input-group-text bg-primary-red border-primary-red rounded-0" type="submit"><i data-lucide="search" class="icon-white"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Filter Buttons Options -->
        <filter class="col-12 my-3"> <!--creame el siguiente filtro-->   </filter>
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
</body>
</html>
