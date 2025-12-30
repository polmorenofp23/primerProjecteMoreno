<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'ProductIngredient.php';

class ProductIngredientDAO
{

    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabasePDO();
    }


    /**
     * Get all ingredients for a specific product
     */
    public function getIngredientsByProduct(int $productId)
    {
        $this->conn = $this->db->connect();

        $query = "SELECT pi.id_product, pi.id_ingredient, pi.grams_per_portion, 
            pi.portion_price, pi.is_default
            FROM product_ingredient pi
            WHERE pi.id_product = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $productIngredientsList = [];
        foreach ($results as $result) {
            $productIngredientsList[] = new ProductIngredient($result);
        }

        return $productIngredientsList;
    }

    /**
     * Get only default ingredients for a product
     */
    public function getDefaultIngredientsByProduct(int $productId)
    {
        $this->conn = $this->db->connect();

        $query = "SELECT pi.id_product, pi.id_ingredient, pi.grams_per_portion, 
            pi.portion_price, pi.is_default
            FROM product_ingredient pi
            WHERE pi.id_product = :product_id AND pi.is_default = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $productIngredientsList = [];
        foreach ($results as $result) {
            $productIngredientsList[] = new ProductIngredient($result);
        }

        return $productIngredientsList;
    }

    /**
     * Get only extra (optional) ingredients for a product
     */
    public function getExtraIngredientsByProduct(int $productId)
    {
        $this->conn = $this->db->connect();

        $query = "SELECT pi.id_product, pi.id_ingredient, pi.grams_per_portion, 
            pi.portion_price, pi.is_default
            FROM product_ingredient pi
            WHERE pi.id_product = :product_id AND pi.is_default = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $productIngredientsList = [];
        foreach ($results as $result) {
            $productIngredientsList[] = new ProductIngredient($result);
        }

        return $productIngredientsList;
    }

    /**
     * Check if a product already has a specific ingredient
     */
    public function hasIngredientInProduct(int $productId, int $ingredientId): bool
    {
        $this->conn = $this->db->connect();

        $query = "SELECT COUNT(*) as count FROM product_ingredient 
                WHERE id_product = :product_id AND id_ingredient = :ingredient_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        return $result['count'] > 0;
    }

    // ----------------- CREATE METHODS -----------------
    /**
     * Add an ingredient to a product using a ProductIngredient model instance.
     * Returns true if successful, false if already exists.
     */
    public function addIngredientToProduct(ProductIngredient $pi): bool
    {
        $productId = (int)$pi->getProductId();
        $ingredientId = (int)$pi->getIngredientId();

        if ($this->hasIngredientInProduct($productId, $ingredientId)) {
            return false;
        }

        $isDefault = (bool)$pi->getIsDefault();
        $gramsPerPortion = (float)$pi->getGramsPerPortion();
        $portionPrice = (float)$pi->getPortionPrice();

        $this->conn = $this->db->connect();

        $query = "INSERT INTO product_ingredient (id_product, id_ingredient, is_default, grams_per_portion, portion_price) 
            VALUES (:product_id, :ingredient_id, :is_default, :grams_per_portion, :portion_price)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->bindValue(':is_default', $isDefault, PDO::PARAM_BOOL);
        $stmt->bindValue(':grams_per_portion', $gramsPerPortion);
        $stmt->bindValue(':portion_price', $portionPrice);
        $stmt->execute();
        $success = $stmt->rowCount() > 0;

        $this->db->disconnect();

        return $success;
    }

    

    /**
     * Add multiple ingredients to a product at once
     * Returns count of successfully added ingredients
     */
    public function addMultipleIngredientsToProduct(int $productId, array $ingredients): int
    {
        $count = 0;
        foreach ($ingredients as $ingredient) {
            if ($ingredient instanceof ProductIngredient) {

                if (!$ingredient->getProductId()) $ingredient->setProductId($productId);
                $success = $this->addIngredientToProduct($ingredient);
            } elseif (is_array($ingredient)) {
                $pi = new ProductIngredient($ingredient);
                if (!$pi->getProductId()) $pi->setProductId($productId);
                $success = $this->addIngredientToProduct($pi);
            } else {
                $success = false;
            }
            if ($success) $count++;
        }
        return $count;
    }

    // ----------------- UPDATE METHODS -----------------
    /**
     * Update ingredient properties in a product
     */
    public function updateIngredientFromProduct(ProductIngredient $pi): bool
    {
        $productId = (int)$pi->getProductId();
        $ingredientId = (int)$pi->getIngredientId();

        $this->conn = $this->db->connect();

        $fields = [];
        $params = [':product_id' => $productId, ':ingredient_id' => $ingredientId];

        $valIsDefault = $pi->getIsDefault();
        $valPortionPrice = $pi->getPortionPrice();
        $valGrams = $pi->getGramsPerPortion();

        $fields[] = "is_default = :is_default";
        $params[':is_default'] = (int)$valIsDefault;

        $fields[] = "portion_price = :portion_price";
        $params[':portion_price'] = (float)$valPortionPrice;

        $fields[] = "grams_per_portion = :grams_per_portion";
        $params[':grams_per_portion'] = (float)$valGrams;

        $query = "UPDATE product_ingredient SET " . implode(", ", $fields) .
            " WHERE id_product = :product_id AND id_ingredient = :ingredient_id";
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $updated = $stmt->rowCount() > 0;

        $this->db->disconnect();

        return $updated;
    }

    // ----------------- DELETE METHODS -----------------
    /**
     * Delete an ingredient association from a product (product_ingredient table).
     * Returns true if a row was deleted, false otherwise.
     */
    public function deleteIngredientFromProduct(int $productId, int $ingredientId): bool
    {
        $this->conn = $this->db->connect();
        
        $query = "DELETE FROM product_ingredient WHERE id_product = :product_id AND id_ingredient = :ingredient_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->execute();
        $deleted = $stmt->rowCount() > 0;
        
        $this->db->disconnect();
        
        return $deleted;
    }

    /**
     * Remove all ingredients from a product
     * Returns count of deleted rows
     */
    public function deleteAllIngredientsFromProduct(int $productId): int
    {
        $this->conn = $this->db->connect();

        $query = "DELETE FROM product_ingredient WHERE id_product = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();

        $this->db->disconnect();

        return $count;
    }
}
