<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product->getName()) ?> - Bees Cavern</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <?php

        renderBCPageTitle([
            'Menu' => '/?controller=Product&action=index',
            'Main Plates' => '?controller=Product&action=index&dishType=' . urlencode($product->getDishType()),
            htmlspecialchars($product->getName()) => null,
        ]);
        ?>

        <main class="product-detail">
            <div class="product-detail-grid">
                <!-- Image Section -->
                <div class="product-image-section">
                    <?php if ($product->getImgDir()): ?>
                        <?php
                            $imgDir = $product->getImgDir();
                            $imgSrc = is_array($imgDir) ? ($imgDir[0] ?? '') : $imgDir;
                        ?>
                        <img src="<?= htmlspecialchars($imgSrc) ?>" 
                             alt="<?= htmlspecialchars($product->getName()) ?>"
                             class="product-main-image">
                    <?php else: ?>
                        <div class="no-image-large">Sense imatge disponible</div>
                    <?php endif; ?>
                </div>

                <!-- Product Info Section -->
                <div class="product-info-section">
                    <h1 class="product-title"><?= htmlspecialchars($product->getName()) ?></h1>
                    
                    <div class="product-meta">
                        <span class="badge badge-type"><?= htmlspecialchars($product->getDishType()) ?></span>
                        
                        <?php if (method_exists($product, 'getAvailable') ? $product->getAvailable() : (method_exists($product, 'getAvaliable') ? $product->getAvaliable() : false)): ?>
                            <span class="badge badge-available">Disponible</span>
                        <?php else: ?>
                            <span class="badge badge-unavailable">No disponible</span>
                        <?php endif; ?>
                    </div>

                    <p class="product-price-large">
                        <?= number_format($product->getPrice(), 2) ?> €
                    </p>

                    <?php if ($product->getDescription()): ?>
                        <div class="product-description-full">
                            <h3>Descripció</h3>
                            <p><?= nl2br(htmlspecialchars($product->getDescription())) ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Ingredients Section -->
                    <?php if (!empty($product->getIngredients())): ?>
                        <div class="product-ingredients">
                            <h3>Ingredients</h3>
                            <div class="ingredients-list">
                                <?php foreach ($product->getIngredients() as $productIngredient): ?>
                                    <div class="ingredient-item">
                                        <span class="ingredient-name">
                                            Ingredient ID: <?= $productIngredient->getIngredientId() ?>
                                        </span>
                                        <span class="ingredient-quantity">
                                            <?= number_format($productIngredient->getGramsPerPortion(), 0) ?>g
                                        </span>
                                        <?php if (!$productIngredient->getIsDefault()): ?>
                                            <span class="ingredient-extra">
                                                +<?= number_format($productIngredient->getPortionPrice(), 2) ?>€
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Add to Cart Section -->
                    <?php if (method_exists($product, 'getAvailable') ? $product->getAvailable() : false): ?>
                        <div class="product-actions-section">
                            <form class="add-to-cart-form" data-product-id="<?= $product->getId() ?>">
                                <div class="quantity-selector">
                                    <label for="quantity">Quantitat:</label>
                                    <input type="number" 
                                           id="quantity" 
                                           name="quantity" 
                                           value="1" 
                                           min="1" 
                                           max="10">
                                </div>
                                
                                <button type="submit" class="btn btn-add-cart-large">
                                    Afegir al carret
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="product-unavailable-notice">
                            <p>Aquest producte no està disponible actualment.</p>
                        </div>
                    <?php endif; ?>

                    <!-- Additional Info -->
                    <div class="product-additional-info">
                        <?php if ($product->getCreatedAt()): ?>
                            <p class="info-item">
                                <strong>Afegit:</strong> 
                                <?= date('d/m/Y', strtotime($product->getCreatedAt())) ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($product->getUpdatedAt()): ?>
                            <p class="info-item">
                                <strong>Última actualització:</strong> 
                                <?= date('d/m/Y', strtotime($product->getUpdatedAt())) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!--<script src="/js/product-cart.js"></script>-->
</body>
</html>