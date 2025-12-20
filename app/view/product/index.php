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
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <?php if ($product->getImgDir()): ?>
                                <?php
                                    $imgDir = $product->getImgDir();
                                    if (is_array($imgDir)) {
                                        $imgSrc = $imgDir[0] ?? '';
                                    } else {
                                        $imgSrc = $imgDir;
                                    }
                                ?>
                                <img src="<?= htmlspecialchars($imgSrc) ?>" 
                                     alt="<?= htmlspecialchars($product->getName()) ?>">
                            <?php else: ?>
                                <div class="no-image">Sense imatge</div>
                            <?php endif; ?>
                        </div>

                        <div class="product-info">
                            <h2 class="product-name">
                                <?= htmlspecialchars($product->getName()) ?>
                            </h2>

                            <p class="product-type">
                                <span class="badge"><?= htmlspecialchars($product->getDishType()) ?></span>
                            </p>

                            <?php if ($product->getDescription()): ?>
                                <p class="product-description">
                                    <?= htmlspecialchars($product->getDescription()) ?>
                                </p>
                            <?php endif; ?>

                            <div class="product-footer">
                                <span class="product-price">
                                    <?= number_format($product->getPrice(), 2) ?> €
                                </span>

                                <div class="product-actions">
                                    <a href="?controller=Product&action=show&id=<?= $product->getId() ?>" 
                                       class="btn btn-details">
                                        Veure detalls
                                    </a>
                                    
                                    <?php if (method_exists($product, 'getAvailable') ? $product->getAvailable() : (method_exists($product, 'getAvaliable') ? $product->getAvaliable() : false)): ?>
                                        <button class="btn btn-add-cart" 
                                                data-product-id="<?= $product->getId() ?>">
                                            Afegir al carret
                                        </button>
                                    <?php else: ?>
                                        <span class="unavailable">No disponible</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <p>No s'han trobat productes.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!--<script src="/js/product-cart.js"></script>-->
</body>
</html>
