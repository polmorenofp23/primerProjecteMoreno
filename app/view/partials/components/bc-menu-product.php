<?php

require_once DAO_PATH . 'ProductRatingDAO.php';

/**
 * Componente para mostrar un producto en el menú usando Bootstrap.
 * Uso: include_once VIEW_PATH . 'partials/components/bc-menu-product.php';
 *       renderBCMenuProduct($product, ['rating'=>4.4]);
 *
 * El componente intenta respetar proporciones (usa la utilidad `ratio`) y
 * ocupa la máxima altura/anchura disponible del contenedor padre usando
 * clases de Bootstrap (`h-100`, `w-100`).
 */

function renderBCMenuProduct(Product $product) {
    $id = $product->getId() ?? null;
    $name = $product->getName() ?? '';
    $price = is_numeric($product->getPrice() ?? null) ? (float)$product->getPrice() : 0.0;
    $dishType = $product->getDishType() ?? '';
    //$description = $product->getDescription() ?? '';
    $imgDir = $product->getImgDir();

    $rating = null; 
    try {
        $prdao = new ProductRatingDAO();
        $avg = $prdao->getProductRatingAverage((int)$id);
        if ($avg !== null) $rating = (float)$avg;
    } catch (Exception $e) {
        $rating = null;
    }
       
    if ($rating === null) $rating = 0.0;


    // Render in html the component
    ?>
    <div class="card bc-menu-product-card h-100">
        <a href="?controller=Product&action=show&id=<?php echo htmlspecialchars((string)$id); ?>" class="text-decoration-none text-reset">
            <div class="ratio ratio-1x1">
                <img src="<?php echo htmlspecialchars($imgDir[0]); ?>" alt="<?php echo htmlspecialchars($name); ?>" class="card-img-top w-100 h-100" style="object-fit:cover;">
            </div>
            <div class="card-body d-flex flex-column">
                <div class="mb-2">
                    <h6 class="card-title mb-0 text-truncate" title="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></h6>
                    <?php if ($dishType !== ''): ?>
                        <small class="text-muted text-uppercase"><?php echo htmlspecialchars($dishType); ?></small>
                    <?php endif; ?>
                </div>

                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="stars" aria-hidden="true">
                            <?php
                                $rounded = (int)round($rating);
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rounded) {
                                        echo '<span class="text-danger">&#9733;</span>'; // filled star
                                    } else {
                                        echo '<span class="text-muted">&#9734;</span>'; // empty star
                                    }
                                }
                            ?>
                        </div>
                        <small class="text-muted ms-1"><?php echo htmlspecialchars(number_format($rating, 1)); ?>/5</small>
                    </div>

                    <div class="text-end">
                        <div class="fw-bold fs-6"><?php echo htmlspecialchars(number_format($price, 2)); ?>€</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php
}

?>
