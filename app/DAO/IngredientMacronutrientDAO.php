<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'IngredientMacronutrient.php';

class IngredientMacronutrientDAO {

    private $db;
    private $conn;

    public function __construct(){
        $this->db = new DatabasePDO();
    }

    /**
     * Get macronutrient association rows for a specific ingredient
     * Returns an array of IngredientMacronutrient model objects
     */
    public function getMacronutrientsByIngredient(int $ingredientId)
    {
        $this->conn = $this->db->connect();

        $query = "SELECT im.id_ingredient, im.id_macronutrient, im.grams_per_100g
                FROM ingredient_macronutrient im
                WHERE im.id_ingredient = :ingredient_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $list = [];
        foreach ($results as $row) {
            $list[] = new IngredientMacronutrient($row);
        }

        return $list;
    }

    /**
     * Add macronutrient data to an ingredient
     */
    public function addMacronutrientToIngredient(IngredientMacronutrient $im): bool
    {
        $this->conn = $this->db->connect();

        $ingredientId = (int)$im->getIngredientId();
        $macronutrientId = (int)$im->getMacronutrientId();
        $grams = (float)$im->getGramsPer100g();

        $query = "INSERT INTO ingredient_macronutrient (id_ingredient, id_macronutrient, grams_per_100g) 
                VALUES (:ingredient_id, :macronutrient_id, :grams)
                ON DUPLICATE KEY UPDATE grams_per_100g = :grams";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->bindValue(':macronutrient_id', $macronutrientId, PDO::PARAM_INT);
        $stmt->bindValue(':grams', $grams);
        $stmt->execute();
        $success = $stmt->rowCount() > 0;

        $this->db->disconnect();

        return $success;
    }

    /**
     * Add multiple IngredientMacronutrient objects to an ingredient
     * Returns count of successfully added rows
     */
    public function addMultipleMacronutrientsToIngredient(array $items): int
    {
        $count = 0;
        foreach ($items as $it) {
            if ($it instanceof IngredientMacronutrient) {
                if ($this->addMacronutrientToIngredient($it)) $count++;
            } elseif (is_array($it)) {
                $im = new IngredientMacronutrient($it);
                if ($this->addMacronutrientToIngredient($im)) $count++;
            }
        }
        return $count;
    }

    /**
     * Update macronutrient value for an ingredient
     */
    public function updateIngredientMacronutrient(IngredientMacronutrient $im): bool
    {
        $this->conn = $this->db->connect();

        $ingredientId = (int)$im->getIngredientId();
        $macronutrientId = (int)$im->getMacronutrientId();
        $grams = (float)$im->getGramsPer100g();

        $query = "UPDATE ingredient_macronutrient 
                SET grams_per_100g = :grams
                WHERE id_ingredient = :ingredient_id AND id_macronutrient = :macronutrient_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->bindValue(':macronutrient_id', $macronutrientId, PDO::PARAM_INT);
        $stmt->bindValue(':grams', $grams);
        $stmt->execute();
        $updated = $stmt->rowCount() > 0;

        $this->db->disconnect();

        return $updated;
    }

    /**
     * Remove macronutrient data from an ingredient
     */
    public function removeMacronutrientFromIngredient(int $ingredientId, int $macronutrientId): bool
    {
        $this->conn = $this->db->connect();
        
        $query = "DELETE FROM ingredient_macronutrient 
                WHERE id_ingredient = :ingredient_id AND id_macronutrient = :macronutrient_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->bindValue(':macronutrient_id', $macronutrientId, PDO::PARAM_INT);
        $stmt->execute();
        $deleted = $stmt->rowCount() > 0;
        
        $this->db->disconnect();

        return $deleted;
    }

}