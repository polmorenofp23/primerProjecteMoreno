<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu - Bees Cavern</title>
    <link rel="stylesheet" href="/css/products-styles.css">
</head>
<body>
    <div class="d-flex flex-column justify-content-center align-items-center col-12">
        <div class="d-flex flex-column flex-md-row justify-content-between justify-content-md-center align-items-center col-12 my-4">
            <div class="col-12 col-md-9 mb-md-4">
                <?php 
                    $incomingUrl = $_SERVER['REQUEST_URI'] ?? '/?controller=Product&action=index';
                    $dishType = $_GET['dish_type'] ?? null;
                    if ($dishType) {
                        $dishTypes = [
                            'appetiser' => 'Appetisers',
                            'main' => 'Main Plates',
                            'dessert' => 'Desserts',
                            'drink' => 'Drinks',
                        ];
                        $label = $dishTypes[$dishType] ?? ucfirst($dishType);
                        renderBCPageTitle([
                            'Menu' => '/?controller=Product&action=index',
                            $label => null,
                        ]);
                    } else {
                        renderBCPageTitle([ 'Menu' => null ]);
                    }
                ?>
            </div>
            <div class="col-6 col-md-3 pe-5">
                <form action="<?php echo htmlspecialchars($incomingUrl); ?>" method="POST" class="w-100">
                    <div class="d-flex flex-row text-primary-red rounded-0">
                        <input name="identifierSearch" class="form-control text-primary-red border-primary-red rounded-0" type="search" 
                            placeholder="Search Product by Name or Id" aria-label="Search products" value="<?php echo htmlspecialchars($_POST['identifierSearch'] ?? ''); ?>">
                        <button class="input-group-text bg-primary-red border-primary-red rounded-0" type="submit"><i data-lucide="search" class="icon-white"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <form action="<?php echo htmlspecialchars($incomingUrl); ?>" method="POST" class="w-100">
            <div class=" products-filter d-flex flex-column flex-lg-row col-11 col-lg-12 justify-content-between align-items-center gap-4 mb-4 px-5">
                <div class="input-group font-sting-light fs-14 text-primary-black"><?php echo count($products ?? []); ?> Product Result</div>

                <div class="input-group ingredient-category-input">
                    <select name="ingredient_category" class="form-select rounded-0 py-2">
                        <option value="" disabled <?php echo empty($_POST['ingredient_category']) ? 'selected' : ''; ?>>Ingredient Class</option>
                        <option value="vegetable" <?php echo (($_POST['ingredient_category'] ?? '') === 'vegetable') ? 'selected' : ''; ?>>Vegetable</option>
                        <option value="fruit" <?php echo (($_POST['ingredient_category'] ?? '') === 'fruit') ? 'selected' : ''; ?>>Fruit</option>
                        <option value="meat" <?php echo (($_POST['ingredient_category'] ?? '') === 'meat') ? 'selected' : ''; ?>>Meat</option>
                        <option value="fish" <?php echo (($_POST['ingredient_category'] ?? '') === 'fish') ? 'selected' : ''; ?>>Fish</option>
                        <option value="seafood" <?php echo (($_POST['ingredient_category'] ?? '') === 'seafood') ? 'selected' : ''; ?>>Seafood</option>
                        <option value="animal_derivative" <?php echo (($_POST['ingredient_category'] ?? '') === 'animal_derivative') ? 'selected' : ''; ?>>Animal Derivative</option>
                        <option value="tree_nut" <?php echo (($_POST['ingredient_category'] ?? '') === 'tree_nut') ? 'selected' : ''; ?>>Tree Nut</option>
                        <option value="spice" <?php echo (($_POST['ingredient_category'] ?? '') === 'spice') ? 'selected' : ''; ?>>Spice</option>
                        <option value="sweetener" <?php echo (($_POST['ingredient_category'] ?? '') === 'sweetener') ? 'selected' : ''; ?>>Sweetener</option>
                        <option value="condiment" <?php echo (($_POST['ingredient_category'] ?? '') === 'condiment') ? 'selected' : ''; ?>>Condiment</option>
                        <option value="natural_fat" <?php echo (($_POST['ingredient_category'] ?? '') === 'natural_fat') ? 'selected' : ''; ?>>Natural Fat</option>
                        <option value="drink" <?php echo (($_POST['ingredient_category'] ?? '') === 'drink') ? 'selected' : ''; ?>>Drink</option>
                    </select>
                </div>

                <div class="input-group allergen-input">
                    <select name="without_allergen" class="form-select rounded-0 py-2">
                        <option value="" disabled <?php echo empty($_POST['without_allergen']) ? 'selected' : ''; ?>>Without Allergen</option>
                        <option value="1" <?php echo (($_POST['without_allergen'] ?? '') === '1') ? 'selected' : ''; ?>>Gluten</option>
                        <option value="2" <?php echo (($_POST['without_allergen'] ?? '') === '2') ? 'selected' : ''; ?>>Soy</option>
                        <option value="3" <?php echo (($_POST['without_allergen'] ?? '') === '3') ? 'selected' : ''; ?>>Fish</option>
                        <option value="4" <?php echo (($_POST['without_allergen'] ?? '') === '4') ? 'selected' : ''; ?>>Crustaceans</option>
                        <option value="5" <?php echo (($_POST['without_allergen'] ?? '') === '5') ? 'selected' : ''; ?>>Molluscs</option>
                        <option value="6" <?php echo (($_POST['without_allergen'] ?? '') === '6') ? 'selected' : ''; ?>>Egg</option>
                        <option value="7" <?php echo (($_POST['without_allergen'] ?? '') === '7') ? 'selected' : ''; ?>>Lactose</option>
                        <option value="8" <?php echo (($_POST['without_allergen'] ?? '') === '8') ? 'selected' : ''; ?>>Mustard</option>
                        <option value="9" <?php echo (($_POST['without_allergen'] ?? '') === '9') ? 'selected' : ''; ?>>Tree Nuts</option>
                    </select>
                </div>

                <div class="input-group gap-3 price-range-input">
                    <input name="price_min" type="number" min="0" class="form-control rounded-0 py-2" placeholder="Price min" value="<?php echo htmlspecialchars($_POST['price_min'] ?? ''); ?>">
                    <input name="price_max" type="number" min="0" class="form-control rounded-0 py-2" placeholder="Price max" value="<?php echo htmlspecialchars($_POST['price_max'] ?? ''); ?>">                
                </div>

                <div class="input-group justify-content-center gap-3">
                    <a class="input-group-text btn-white rounded-0 px-3 py-2" href="<?php echo htmlspecialchars($incomingUrl); ?>">Reset</a>
                    <button class="input-group-text btn-red rounded-0 px-3 py-2" type="submit">Apply</button>
                </div>

                <div class="input-group">
                    <select name="order_by" class="form-select rounded-0 py-2">
                        <option value="" disabled <?php echo empty($_POST['order_by']) ? 'selected' : ''; ?>>Sort By</option>
                        <option value="price_asc" <?php echo (($_POST['order_by'] ?? '') === 'price_asc') ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_desc" <?php echo (($_POST['order_by'] ?? '') === 'price_desc') ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="name" <?php echo (($_POST['order_by'] ?? '') === 'name') ? 'selected' : ''; ?>>Name</option>
                    </select>
                </div>
            </div>
        </form>
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
