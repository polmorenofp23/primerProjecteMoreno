<?php

require_once DAO_PATH . 'ProductDAO.php';
require_once DAO_PATH . 'ProductIngredientDAO.php';

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
        
        $id = intval($_GET["id"]);
        $productDAO = new ProductDAO();
        $product = $productDAO->getProductsByFilter(['id' => $id])[0] ?? null;

        if ($product) {
            $piDao = new ProductIngredientDAO();
            $ingredients = $piDao->getIngredientsByProduct((int)$id);
            $product->setIngredients($ingredients);
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

        // dish_type - accept comma separated list or single value
        if (isset($_GET['dish_type']) && $_GET['dish_type'] !== '') {
            $val = trim($_GET['dish_type']);
            if (strpos($val, ',') !== false) {
                $filters['dish_type'] = array_map('trim', explode(',', $val));
            } else {
                $filters['dish_type'] = $val;
            }
        }

        // availability
        if (isset($_GET['available'])) {
            $filters['available'] = (bool)intval($_GET['available']);
        }

        // price range: price_min and price_max
        if (isset($_GET['price_min']) || isset($_GET['price_max'])) {
            $min = isset($_GET['price_min']) ? floatval($_GET['price_min']) : 0.0;
            $max = isset($_GET['price_max']) ? floatval($_GET['price_max']) : 0.0;
            $filters['price_range'] = [$min, $max];
        }

        // ingredient_category - accept csv or single
        if (isset($_GET['ingredient_category']) && $_GET['ingredient_category'] !== '') {
            $val = trim($_GET['ingredient_category']);
            if (strpos($val, ',') !== false) {
                $filters['ingredient_category'] = array_map('trim', explode(',', $val));
            } else {
                $filters['ingredient_category'] = $val;
            }
        }

        // allergens: contains_allergen / without_allergen (accept csv or single)
        if (isset($_GET['contains_allergen']) && $_GET['contains_allergen'] !== '') {
            $val = trim($_GET['contains_allergen']);
            if (strpos($val, ',') !== false) {
                $filters['contains_allergen'] = array_map('intval', array_map('trim', explode(',', $val)));
            } else {
                $filters['contains_allergen'] = intval($val);
            }
        }
        if (isset($_GET['without_allergen']) && $_GET['without_allergen'] !== '') {
            $val = trim($_GET['without_allergen']);
            if (strpos($val, ',') !== false) {
                $filters['without_allergen'] = array_map('intval', array_map('trim', explode(',', $val)));
            } else {
                $filters['without_allergen'] = intval($val);
            }
        }

        // ids (accept csv or single)
        if (isset($_GET['ids']) && $_GET['ids'] !== '') {
            $filters['id'] = array_map('intval', array_map('trim', explode(',', $_GET['ids'])));
        }

        // order_by
        $orderBy = $_GET['order_by'] ?? null;

        // Delegate to the unified DAO filter method
        $products = $productDAO->getProductsByFilter($filters, $orderBy);
        
        include_once VIEW_PATH . 'main.php';
    }
}
