<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'Allergen.php';

class AllergenDAO{

    private $db;
    private $conn;

    public function __construct(){
        $this->db = new DatabasePDO();
    }

    /**
     * Get an allergen by its id
     */
    public function getAllergenById(int $id)
    {
        $this->conn = $this->db->connect();
        
        $query = "SELECT * FROM allergen WHERE id_allergen = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->db->disconnect();

        if (!$result) return null;
        return new Allergen($result);
    }

    /**
     * Get all allergens from the database
     */
    public function getAllAllergens()
    {
        $this->conn = $this->db->connect();
        
        $query = "SELECT * FROM allergen";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->db->disconnect();

        $allergensList = [];
        foreach ($results as $row) {
            $allergensList[] = new Allergen($row);
        }

        return $allergensList;
    }

    /**
     * Get all allergens present in a specific ingredient
     */
    public function getAllergensByIngredient(int $ingredientId)
    {
        $this->conn = $this->db->connect();
        
        $query = "SELECT a.* 
                FROM allergen a
                JOIN ingredient_allergen ia ON a.id_allergen = ia.id_allergen
                WHERE ia.id_ingredient = :ingredient_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->db->disconnect();

        $allergensList = [];
        foreach ($results as $row) {
            $allergensList[] = new Allergen($row);
        }

        return $allergensList;
    }

    /**
     * Get all allergens present in a specific product (through its ingredients)
     */
    public function getAllergensByProduct(int $productId)
    {
        $this->conn = $this->db->connect();
        
        $query = "SELECT DISTINCT a.* 
                FROM allergen a
                JOIN ingredient_allergen ia ON a.id_allergen = ia.id_allergen
                JOIN product_ingredient pi ON ia.id_ingredient = pi.id_ingredient
                WHERE pi.id_product = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->db->disconnect();

        $allergensList = [];
        foreach ($results as $row) {
            $allergensList[] = new Allergen($row);
        }

        return $allergensList;
    }

    // ----------------- CREATE METHODS -----------------
    /**
     * Associate an allergen with an ingredient
     */
    public function addAllergenToIngredient(IngredientAllergen $ia): bool
    {
        $this->conn = $this->db->connect();

        $ingredientId = (int)$ia->getIngredientId();
        $allergenId = (int)$ia->getAllergenId();

        $query = "INSERT IGNORE INTO ingredient_allergen (id_ingredient, id_allergen) 
                VALUES (:ingredient_id, :allergen_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->bindValue(':allergen_id', $allergenId, PDO::PARAM_INT);
        $stmt->execute();
        $success = $stmt->rowCount() > 0;

        $this->db->disconnect();

        return $success;
    }

    /**
     * Add multiple IngredientAllergen associations. Accepts array of objects or arrays.
     * Returns count of successful inserts.
     */
    public function addMultipleAllergensToIngredient(array $items): int
    {
        $count = 0;
        foreach ($items as $it) {
            if ($it instanceof IngredientAllergen) {
                if ($this->addAllergenToIngredient($it)) $count++;
            } elseif (is_array($it)) {
                $ia = new IngredientAllergen($it);
                if ($this->addAllergenToIngredient($ia)) $count++;
            }
        }
        return $count;
    }

    // ----------------- DELETE METHODS -----------------
    /**
     * Remove allergen association from an ingredient
     */
    public function removeAllergenFromIngredient(IngredientAllergen $ia): bool
    {
        $this->conn = $this->db->connect();

        $ingredientId = (int)$ia->getIngredientId();
        $allergenId = (int)$ia->getAllergenId();

        $query = "DELETE FROM ingredient_allergen 
                WHERE id_ingredient = :ingredient_id AND id_allergen = :allergen_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->bindValue(':allergen_id', $allergenId, PDO::PARAM_INT);
        $stmt->execute();
        $deleted = $stmt->rowCount() > 0;

        $this->db->disconnect();

        return $deleted;
    }
}
