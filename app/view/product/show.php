<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= htmlspecialchars($product->getName()) ?> - Bees Cavern</title>
    <link rel="stylesheet" href="/css/products-styles.css">
</head>
<body>
    <div class="d-flex flex-column justify-content-center align-items-center col-12">
        <div class="d-flex justify-content-start align-items-center col-12 my-4">
            <?php
                $dishType = $product->getDishType();
                if ($dishType) {
                    $dishTypes = [
                        'appetiser' => 'Appetisers',
                        'main' => 'Main Plates',
                        'dessert' => 'Desserts',
                        'drink' => 'Drinks',
                    ];
                    $dishTypeLabel = $dishTypes[$dishType] ?? ucfirst($dishType);
                    renderBCPageTitle([
                        'Menu' => '/?controller=Product&action=index',
                        $dishTypeLabel => '?controller=Product&action=index&dishType=' . urlencode($product->getDishType()),
                        htmlspecialchars($product->getName()) => null
                    ]);
                } else {
                    renderBCPageTitle([ htmlspecialchars($product->getName()) => null ]);
                }
            ?>            
        </div>

        <div class="product-detail d-flex flex-row justify-content-center align-items-start col-10">
            <div class="d-flex justify-content-center align-items-center col-8">
                <div class="product-image-wrapper">
                    <?php if (count($productImages) > 1): ?>
                        <?php $carouselId = 'productCarousel-' . htmlspecialchars($product->getId());?>
                        <div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <?php foreach ($productImages as $prodImg => $img): ?>
                                    <button type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide-to="<?= $prodImg ?>" 
                                        <?= $prodImg === 0 ? 'class="active" aria-current="true"' : '' ?> aria-label="Slide <?= $prodImg+1 ?>">
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <div class="carousel-inner">
                                <?php foreach ($productImages as $prodImg => $img): ?>
                                    <div class="carousel-item <?= $prodImg === 0 ? 'active' : '' ?>">
                                        <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100 product-main-image" alt="<?= htmlspecialchars($product->getName()) ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    <?php else: ?>
                        <img src="<?= htmlspecialchars($productImages[0]) ?>" alt="<?= htmlspecialchars($product->getName()) ?>" class="product-main-image">
                    <?php endif; ?>

                    <div class="carousel-overlay p-3 d-flex justify-content-between align-items-center">
                        <?php if (isset($productContainedAllergens) && !empty($productContainedAllergens)): ?>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <?php foreach ($productContainedAllergens as $allergen): ?>
                                    <?= $allergen->renderIconOrName('color', 'width="40" height="40"') ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-end align-items-center">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <div class="stars" style="font-size:35px;" aria-hidden="true">
                                    <?php
                                        $rounded = (int)round($productRating);
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rounded) {
                                                echo '<span class="text-primary-red">&#9733;</span>'; // filled star
                                            } else {
                                                echo '<span class="text-primary-red">&#9734;</span>'; // empty star
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <span class="font-sting-light fs-20 text-primary-red ms-2"><?= htmlspecialchars(number_format($productRating, 1)) ?>/5</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column justify-content-start col-4 gap-3">
                
                <div class="d-flex flex-column justify-content-center align-items-start">
                    <h6 class="font-sting-light fs-20 text-primary-black"><?= htmlspecialchars($product->getName()) ?></h6>
                    <span class="font-sting-regular fs-20 text-primary-black"><?= number_format($product->getPrice(), 2) ?> €</span>
                </div>

                <!-- Options donenness NOT IMPLEMENTED
                <div class="product-options mt-3">
                    <label class="option-label">Doneness</label>
                    <div class="doneness-options d-flex">
                        <label class="doneness-option"><input type="radio" name="doneness" value="rare"> Rare</label>
                        <label class="doneness-option"><input type="radio" name="doneness" value="medium-rare" checked> Medium-rare</label>
                        <label class="doneness-option"><input type="radio" name="doneness" value="medium-well"> Medium-well</label>
                        <label class="doneness-option"><input type="radio" name="doneness" value="overcooked"> Overcooked</label>
                    </div>
                </div>-->
                <div class="my-5"></div>

                <button class="btn-white bg-secondary-white w-100 py-3" disabled> <!-- text-primary-grey -->
                    <i data-lucide="pencil"></i>
                    <span class="font-sting-light fs-16">Personalize Ingredients</span>
                </button>

                <div class="d-flex align-items-center gap-2">
                    <?php if (method_exists($product, 'getAvailable') ? $product->getAvailable() : false): ?>
                        <form class="add-to-cart-form d-flex align-items-center gap-2 w-100" data-product-id="<?= $product->getId() ?>">
                            <div class="input-group w-25">
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="10" class="w-100 py-3 text-center">
                            </div>
                            <button type="submit" class="btn-red w-100 py-3">ADD TO ORDER</button>
                        </form>
                        <button class="btn-white p-3" disabled title="Add to favourites (not implemented)">
                            <i data-lucide="heart" class=""></i>
                        </button>
                    <?php else: ?>
                        <div class="font-sting-light fs-16 color-primary-grey">Product not available right now</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="product-macros d-flex flex-column justify-content-center align-items-center col-12">

            <h3 class="font-sting-light fs-200 text-secondary-white text-uppercase text-center my-0">MACRO<br>NUTRIENTS</h3>
            <div class="macros-values white-bg d-flex justify-content-center align-items-center gap-4 col-12">
                <div class="macro-item d-flex flex-column justify-content-center align-items-center col-10">
                    
                    <span class="justify-content-start font-sting-regular fs-60 text-primary-red uppercase w-100">GENERAL</span>
                    <hr class="flex-fill border-1 border-primary-grey mt-4 mx-3 opacity-75 w-100">

                    <div class="d-flex justify-content-evenly align-items-center w-100 mt-3">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <span class="font-sting-regular fs-24 text-primary-red uppercase">GRAMS</span>
                            <span class="font-sting-regular fs-100 text-primary-red">Xg</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <span class="font-sting-regular fs-24 text-primary-red text-center uppercase">ENERGETIC<br>VALUES</span>
                            <span class="font-sting-regular fs-100 text-primary-red">X Kcal</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-around align-items-center w-100 mt-3">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <span class="font-sting-regular fs-24 text-primary-red uppercase">PROTEINS</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <span class="font-sting-regular fs-24 text-primary-red uppercase">FATS</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <span class="font-sting-regular fs-24 text-primary-red uppercase">CARBOHYDRATES</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column justify-content-center align-items-center col-12">
            <div class="red-bg d-flex flex-column justify-content-center align-items-center col-12 p-5">
                <div class="d-flex flex-row justify-content-center align-items-center col-10">
                    <span class="font-sting-light fs-48 text-primary-white text-start text-nowrap text-uppercase">
                        <?= htmlspecialchars($product->getName()) ?>
                    </span>
                    <hr class="flex-fill border-1 border-white mt-4 mx-3 opacity-75">
                </div>

                <img src="<?= htmlspecialchars($productImages[0]) ?>" alt="<?= htmlspecialchars($product->getName()) ?>" width="500" height="500" class="product-main-image my-5">

                <div class="d-flex flex-row justify-content-center align-items-center col-10 mb-5">
                    <hr class="flex-fill border-1 border-primary-white opacity-75 mx-3 mt-4">
                    <span class="font-sting-light fs-60 text-primary-white text-end text-nowrap">
                        <?= number_format($product->getPrice(), 2) ?> €
                    </span>
                </div>
            </div>

            <div class="product-info d-flex justify-content-between bg-secondary-white shadow p-4 col-10">
                <div class="text-center flex-fill">
                    <h5 class="font-karla-regular fs-20 text-primary-dark-red text-uppercase">Dish Type</h5>
                    <p class="font-sting-regular fs-16 text-primary-dark-red text-uppercase mt-3"><?= htmlspecialchars($product->getDishType() ?? '—') ?></p>
                </div>

                <div class="text-center flex-fill">
                    <h5 class="font-karla-regular fs-20 text-primary-dark-red text-uppercase">Allergens</h5>
                    <div class="font-sting-regular fs-16 text-primary-dark-red text-uppercase mt-2">
                        <?php foreach ($productContainedAllergens as $allergen): ?>
                            <?= $allergen->renderIconOrName('txt', 'width="50" height="50"') ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="text-center flex-fill">
                    <h5 class="font-karla-regular fs-20 text-primary-dark-red text-uppercase">Available</h5>
                    <p class="font-sting-regular fs-16 text-primary-dark-red text-uppercase mt-3">
                        <?php if ((bool)$product->getAvailable()): ?>
                            <i data-lucide="circle-check" class="text-success" aria-hidden="true"></i>
                        <?php else: ?>
                            <i data-lucide="circle-x" class="text-danger" aria-hidden="true"></i>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <div class="product-description d-flex flex-column justify-content-center align-items-start col-8 gap-3 my-5">

                <?php if ($product->getDescription()): ?>
                    <div class="my-4">
                        <h3 class="fs-32 text-capitalize">Description</h3>
                        <p class="text-primary-dark-red"><?= htmlspecialchars($product->getDescription()) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($productIngredients)): ?>
                    <div class="product-ingredients-list d-flex flex-column justify-content-center align-items-start my-4">
                        <h3 class="fs-32 text-capitalize">Ingredients</h3>
                        <ul class="w-100">
                            <?php foreach ($productIngredients as $pi): ?>
                                <?php
                                    $igId = $pi->getIngredientId() ?? null;
                                    $ingredientObj = null;
                                    if (!empty($igId) && !empty($ingredients) && is_array($ingredients)) {
                                        foreach ($ingredients as $cand) {
                                           $candId = $cand->getId() ?? null;
                                            if ($candId !== null && (string)$candId === (string)$igId) {
                                                $ingredientObj = $cand;
                                                break;
                                            }
                                        }
                                    }

                                    $igName = $ingredientObj->getName() ?? null;
                                    $igCategory = $ingredientObj->getCategory() ?? null;
                                    $igCountry = $ingredientObj->getCountry() ?? null;
                                    $igGrams = $pi->getGramsPerPortion() ?? null;

                                    $igContainedAllergens = [];
                                    $igContainedAllergens = $allergenDao->getAllergensByIngredient((int)$igId);
                                ?>
                                <li class="d-flex align-items-center text-primary-dark-red w-100">
                                    <div class="d-flex align-items-center gap-2 flex-grow-1">
                                        <span class="fs-20 fw-bold"><?= htmlspecialchars($igName) ?></span>
                                        <?php if ($igCountry): ?> <span class="fs-14">(<?= htmlspecialchars($igCountry) ?>)</span> <?php endif; ?>
                                        <span class="fs-20 fw-bold">:</span>
                                        <span class="fs-20"><?= number_format($igGrams,0) ?> g</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 ms-4">
                                        <?php foreach ($igContainedAllergens as $a): ?>
                                            <?= $a->renderIconOrName('txt', 'width="40" height="40"') ?>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>