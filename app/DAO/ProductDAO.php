<?php

require_once __DIR__ . "/../core/DatabasePDO.php";
require_once __DIR__ . "/../models/Product.php";

class ProductDAO{

    private $db;
    private $conn;
    private $tableName;
    private $productsList = [];

    public function __construct(){
        $this->db = new DatabasePDO();
    }

    /**
     * It returns a product by its id
     */
    public static function getProductById($id)
    {
        $conn = DatabasePDO::connect();
        $query = "SELECT * FROM product WHERE id_product = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        DatabasePDO::disconnect();

        if (!$result) return null;
        //if (isset($result['min_price'])) $result['price'] = $result['min_price'];              // normalize column name
        return new Product($result);
    }

    /**
     * It returns all products from the database
     */
    public static function getAllProducts()
    {
        $conn = DatabasePDO::connect();
        $query = "SELECT * FROM product";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        DatabasePDO::disconnect();

        $productsList = [];
        while ($product = $result->fetch_object('Product')) {
            $productsList[] = $product;
        }

        return $productsList;
    }

    /**
     * It returns products that match the given price
     */
    public static function getProductsByPrice($price)
    {
        $conn = DatabasePDO::connect();
        $query = "SELECT * FROM product WHERE min_price = :price";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':price', $price);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        DatabasePDO::disconnect();

        $productsList = [];
        while ($product = $results->fetch_object('Product')) {
            $productsList[] = $product;
        }

        return $productsList;
    }

    /**
     * It returns a list of the products between the price range
     */
    public static function getProductsByPriceRange($min_price, $max_price)
    {
        $conn = DatabasePDO::connect();
        $query = "SELECT * FROM product WHERE min_price BETWEEN :min_price AND :max_price";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':min_price', $min_price);
        $stmt->bindValue(':max_price', $max_price);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        DatabasePDO::disconnect();

        $productsList = [];
        foreach ($results as $result) {
            if (isset($result['min_price'])) $result['price'] = $result['min_price'];
            $productsList[] = new Product($result);
        }

        return $productsList;
    }

    /**
     * It returns products that match the given dish type
     */
    public static function getProductsByDishType($dish_type)
    {
        $conn = DatabasePDO::connect();
        $query = "SELECT * FROM product WHERE dish_type = :dish_type";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':dish_type', $dish_type);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        DatabasePDO::disconnect();

        $productsList = [];
        while ($product = $results->fetch_object('Product')) {
            $productsList[] = $product;
        }

        return $productsList;
    }

    /**
     * Returns products that contain ingredients of a given category (ingredient class)
     */
    public static function getProductsByIngredientCategory(string $category)
    {
        $conn = DatabasePDO::connect();
         // ---------- REVISAR QUERY -------------
        $query = "SELECT DISTINCT p.id_product, p.name, p.description, p.dish_type, p.min_price, p.img_dir, p.available, p.created_at, p.updated_at
                FROM product p
                JOIN product_ingredient pi ON p.id_product = pi.id_product
                JOIN ingredient i ON i.id_ingredient = pi.id_ingredient
                WHERE i.category = :category";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':category', $category);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        DatabasePDO::disconnect();

        $productsList = [];
        while ($product = $results->fetch_object('Product')) {
            $productsList[] = $product;
        }
        return $productsList;
    }

    /**
     * Returns products that DO NOT contain the given allergen (single allergen id)
     */
    public static function getProductsWithoutAllergen(int $allergenId)
    {
        $conn = DatabasePDO::connect();
        $query = "SELECT * FROM product
                WHERE id_product NOT IN (
                    SELECT DISTINCT pi.id_product
                    FROM product_ingredient pi
                    JOIN ingredient_allergen ia ON ia.id_ingredient = pi.id_ingredient
                    WHERE ia.id_allergen = :allergen
                )";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':allergen', $allergenId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        DatabasePDO::disconnect();

        $productsList = [];
        while ($product = $results->fetch_object('Product')) {
            $productsList[] = $product;
        }
        return $productsList;
    }

    /**
     * Returns products by availability status (1 = available, 0 = not available)
     */
    public static function getProductsByAvailability(int $available = 1)
    {
        $conn = DatabasePDO::connect();
        $query = "SELECT * FROM product WHERE available = :available";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':available', $available, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        DatabasePDO::disconnect();

        $productsList = [];
        while ($product = $results->fetch_object('Product')) {
            $productsList[] = $product;
        }
        return $productsList;
    }

    /**
     * Delete an ingredient association from a product (product_ingredient table).
     * Returns true if a row was deleted, false otherwise.
     */
    public static function deleteIngredientFromProduct(int $productId, int $ingredientId): bool
    {
        $conn = DatabasePDO::connect();
        $query = "DELETE FROM product_ingredient WHERE id_product = :product_id AND id_ingredient = :ingredient_id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->execute();
        $deleted = $stmt->rowCount() > 0;
        DatabasePDO::disconnect();
        return $deleted;
    }
}