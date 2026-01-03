<?php

require_once DAO_PATH . 'ProductDAO.php';
require_once DAO_PATH . 'ProductIngredientDAO.php';
require_once DAO_PATH . 'ProductRatingDAO.php';
//require_once DAO_PATH . 'ProductFavouriteDAO.php';
require_once DAO_PATH . 'IngredientDAO.php';
require_once DAO_PATH . 'IngredientMacronutrientDAO.php';
require_once DAO_PATH . 'AllergenDAO.php';
require_once DAO_PATH . 'MacronutrientDAO.php';


class ProductController
{
    /**
     * Show a single product by ID
     */
    public function show()
    {
        $view = 'product/show.php';
        
        if (!isset($_GET["id"])) {
            header('Location: ?controller=Product&action=index');
            exit;
        }
        
        $productId = intval($_GET["id"]);
        $productDAO = new ProductDAO();
        $product = $productDAO->getProductsByFilter(['id' => $productId])[0] ?? null;

        if ($product) {
            $piDao = new ProductIngredientDAO();
            $productIngredients = $piDao->getIngredientsByProduct((int)$productId);
            $product->setIngredients($productIngredients);

            $ingredients = [];
            $generalMacronutrients = [];
            //$generalAllergens = [];
            $productContainedAllergens = [];
            $productRating = null;

            $ingredientDao = new IngredientDAO();
            $imDao = new IngredientMacronutrientDAO();
            $allergenDao = new AllergenDAO();
            $macroDao = new MacronutrientDAO();
            $prodRatDAO = new ProductRatingDAO();

            $generalMacronutrients = $macroDao->getAllMacronutrients();
            //$generalAllergens = $allergenDao->getAllAllergens();
            $productContainedAllergens = $allergenDao->getAllergensByProduct((int)$productId);
            $productRating = $prodRatDAO->getProductRatingAverage((int)$product->getId()) ?? 0.0;
           
            foreach ($productIngredients as $pi) { 
                $ingredientId = $pi->getIngredientId();
                if (!$ingredientId) continue;

                $ingredient = $ingredientDao->getIngredientById((int)$ingredientId);
                if (!$ingredient) continue;

                $ingredients[] = $ingredient;
            }

            $imgDir = $product->getImgDir();
            $productImages = [];
            $defaultImg = '/assets/img/products/default.webp';
            if (is_array($imgDir) && !empty($imgDir)) {
                foreach ($imgDir as $candidate) {
                    $candidate = (string)$candidate;
                    if (!$candidate) continue;
                    $fsPath = rtrim((string)$_SERVER['DOCUMENT_ROOT'], "\\/") . '/' . ltrim($candidate, '/');
                    if (file_exists($fsPath)) {
                        $productImages[] = '/' . ltrim($candidate, '/');
                    }
                }
            } 
            if (empty($productImages)) $productImages[] = $defaultImg;
        }
        
        if (!$product) {
            header('Location: ?controller=Error&action=show&code=404&message=Product+not+found');
            exit;
        }
        
        include_once VIEW_PATH . 'main.php';
    }

    /**
     * List all products with optional filters
     */
    public function index()
    {
        $view = 'product/index.php'; 
        $productDAO = new ProductDAO();
        $filters = [];

        // identifierSearch - can be id or name
        $identifier = $_POST['identifierSearch'] ?? null;
        if ($identifier !== null && trim((string)$identifier) !== '') {
            $identifier = trim((string)$identifier);
            if (ctype_digit($identifier)) {
                $filters['id'] = (int)$identifier;
            } else {
                $filters['name_like'] = $identifier;
            }
        }

        // dish_type - accept comma separated list or single value (accepts GET or POST)
        if (isset($_REQUEST['dish_type']) && $_REQUEST['dish_type'] !== '') {
            $val = trim($_REQUEST['dish_type']);
            if (strpos($val, ',') !== false) {
                $filters['dish_type'] = array_map('trim', explode(',', $val));
            } else {
                $filters['dish_type'] = $val;
            }
        }

        // price range: price_min and price_max
        $priceMinRaw = $_POST['price_min'] ?? null;
        $priceMaxRaw = $_POST['price_max'] ?? null;
        $priceMinSet = isset($priceMinRaw) && trim((string)$priceMinRaw) !== '';
        $priceMaxSet = isset($priceMaxRaw) && trim((string)$priceMaxRaw) !== '';
        if ($priceMinSet || $priceMaxSet) {
            $min = $priceMinSet ? floatval($priceMinRaw) : 0.0;
            $max = $priceMaxSet ? floatval($priceMaxRaw) : 999.0;
            $filters['price_range'] = [$min, $max];
        }

        // ingredient_category - accept csv or single
        if (isset($_POST['ingredient_category']) && $_POST['ingredient_category'] !== '') {
            $val = trim($_POST['ingredient_category']);
            if (strpos($val, ',') !== false) {
                $filters['ingredient_category'] = array_map('trim', explode(',', $val));
            } else {
                $filters['ingredient_category'] = $val;
            }
        }

        if (isset($_POST['without_allergen']) && $_POST['without_allergen'] !== '') {
            $val = trim($_POST['without_allergen']);
            if (strpos($val, ',') !== false) {
                $filters['without_allergen'] = array_map('intval', array_map('trim', explode(',', $val)));
            } else {
                $filters['without_allergen'] = intval($val);
            }
        }

        $filters['available'] = true; // Always filtr only for the available products
        $orderBy = $_POST['order_by'] ?? null;
        $products = $productDAO->getProductsByFilter($filters, $orderBy);
        include_once VIEW_PATH . 'main.php';
    }
}