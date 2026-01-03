<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'OrderLineIngredient.php';

class OrderLineIngredientDAO
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabasePDO();
    }

    /**
     * Get all ingredients for a specific order line
     */
    public function getIngredientsByOrderLine(int $lineId)
    {
        $this->conn = $this->db->connect();

        $query = "SELECT oli.id_line, oli.id_ingredient, oli.num_portions, 
            oli.ingredient_price, oli.grams, oli.kcal_component, 
            oli.protein_g, oli.carbs_g, oli.fat_g, oli.origin, oli.doneness
            FROM order_line_ingredient oli
            WHERE oli.id_line = :line_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':line_id', $lineId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $ingredientsList = [];
        foreach ($results as $result) {
            $ingredientsList[] = new OrderLineIngredient($result);
        }

        return $ingredientsList;
    }

    /**
     * Get only default ingredients for an order line
     */
    public function getDefaultIngredientsByOrderLine(int $lineId)
    {
        $this->conn = $this->db->connect();

        $query = "SELECT oli.id_line, oli.id_ingredient, oli.num_portions, 
            oli.ingredient_price, oli.grams, oli.kcal_component, 
            oli.protein_g, oli.carbs_g, oli.fat_g, oli.origin, oli.doneness
            FROM order_line_ingredient oli
            WHERE oli.id_line = :line_id AND oli.origin = 'default'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':line_id', $lineId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $ingredientsList = [];
        foreach ($results as $result) {
            $ingredientsList[] = new OrderLineIngredient($result);
        }

        return $ingredientsList;
    }

    /**
     * Get only extra ingredients for an order line
     */
    public function getExtraIngredientsByOrderLine(int $lineId)
    {
        $this->conn = $this->db->connect();

        $query = "SELECT oli.id_line, oli.id_ingredient, oli.num_portions, 
            oli.ingredient_price, oli.grams, oli.kcal_component, 
            oli.protein_g, oli.carbs_g, oli.fat_g, oli.origin, oli.doneness
            FROM order_line_ingredient oli
            WHERE oli.id_line = :line_id AND oli.origin = 'extra'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':line_id', $lineId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $ingredientsList = [];
        foreach ($results as $result) {
            $ingredientsList[] = new OrderLineIngredient($result);
        }

        return $ingredientsList;
    }

    /**
     * Check if an order line already has a specific ingredient
     */
    public function hasIngredientInOrderLine(int $lineId, int $ingredientId): bool
    {
        $this->conn = $this->db->connect();

        $query = "SELECT COUNT(*) as count FROM order_line_ingredient 
                WHERE id_line = :line_id AND id_ingredient = :ingredient_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':line_id', $lineId, PDO::PARAM_INT);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        return $result['count'] > 0;
    }

    // ----------------- CREATE METHODS -----------------
    /**
     * Add an ingredient to an order line using an OrderLineIngredient model instance
     */
    public function addIngredientToOrderLine(OrderLineIngredient $oli): bool
    {
        $lineId = (int)$oli->getLineId();
        $ingredientId = (int)$oli->getIngredientId();

        if ($this->hasIngredientInOrderLine($lineId, $ingredientId)) {
            return false;
        }

        $this->conn = $this->db->connect();

        $query = "INSERT INTO order_line_ingredient 
            (id_line, id_ingredient, num_portions, ingredient_price, grams, 
            kcal_component, protein_g, carbs_g, fat_g, origin, doneness) 
            VALUES 
            (:id_line, :id_ingredient, :num_portions, :ingredient_price, :grams, 
            :kcal_component, :protein_g, :carbs_g, :fat_g, :origin, :doneness)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_line', $lineId, PDO::PARAM_INT);
        $stmt->bindValue(':id_ingredient', $ingredientId, PDO::PARAM_INT);
        $stmt->bindValue(':num_portions', $oli->getNumPortions(), PDO::PARAM_INT);
        $stmt->bindValue(':ingredient_price', $oli->getIngredientPrice());
        $stmt->bindValue(':grams', $oli->getGrams());
        $stmt->bindValue(':kcal_component', $oli->getKcalComponent());
        $stmt->bindValue(':protein_g', $oli->getProteinG());
        $stmt->bindValue(':carbs_g', $oli->getCarbsG());
        $stmt->bindValue(':fat_g', $oli->getFatG());
        $stmt->bindValue(':origin', $oli->getOrigin());
        $stmt->bindValue(':doneness', $oli->getDoneness());
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    // ----------------- UPDATE METHODS -----------------
    /**
     * Update an order line ingredient
     */
    public function updateOrderLineIngredient(OrderLineIngredient $oli): bool
    {
        $this->conn = $this->db->connect();

        $query = "UPDATE order_line_ingredient SET 
            num_portions = :num_portions,
            ingredient_price = :ingredient_price,
            grams = :grams,
            kcal_component = :kcal_component,
            protein_g = :protein_g,
            carbs_g = :carbs_g,
            fat_g = :fat_g,
            origin = :origin,
            doneness = :doneness
            WHERE id_line = :id_line AND id_ingredient = :id_ingredient";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_line', $oli->getLineId(), PDO::PARAM_INT);
        $stmt->bindValue(':id_ingredient', $oli->getIngredientId(), PDO::PARAM_INT);
        $stmt->bindValue(':num_portions', $oli->getNumPortions(), PDO::PARAM_INT);
        $stmt->bindValue(':ingredient_price', $oli->getIngredientPrice());
        $stmt->bindValue(':grams', $oli->getGrams());
        $stmt->bindValue(':kcal_component', $oli->getKcalComponent());
        $stmt->bindValue(':protein_g', $oli->getProteinG());
        $stmt->bindValue(':carbs_g', $oli->getCarbsG());
        $stmt->bindValue(':fat_g', $oli->getFatG());
        $stmt->bindValue(':origin', $oli->getOrigin());
        $stmt->bindValue(':doneness', $oli->getDoneness());
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    /**
     * Update only the doneness of an ingredient in an order line
     */
    public function updateDoneness(int $lineId, int $ingredientId, ?string $doneness): bool
    {
        $this->conn = $this->db->connect();

        $query = "UPDATE order_line_ingredient SET doneness = :doneness 
                WHERE id_line = :id_line AND id_ingredient = :id_ingredient";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_line', $lineId, PDO::PARAM_INT);
        $stmt->bindValue(':id_ingredient', $ingredientId, PDO::PARAM_INT);
        $stmt->bindValue(':doneness', $doneness);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    /**
     * Update only the number of portions for an ingredient
     */
    public function updateNumPortions(int $lineId, int $ingredientId, int $numPortions): bool
    {
        $this->conn = $this->db->connect();

        $query = "UPDATE order_line_ingredient SET num_portions = :num_portions 
                WHERE id_line = :id_line AND id_ingredient = :id_ingredient";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_line', $lineId, PDO::PARAM_INT);
        $stmt->bindValue(':id_ingredient', $ingredientId, PDO::PARAM_INT);
        $stmt->bindValue(':num_portions', $numPortions, PDO::PARAM_INT);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    // ----------------- DELETE METHODS -----------------
    /**
     * Remove an ingredient from an order line
     */
    public function removeIngredientFromOrderLine(int $lineId, int $ingredientId): bool
    {
        $this->conn = $this->db->connect();

        $query = "DELETE FROM order_line_ingredient 
                WHERE id_line = :line_id AND id_ingredient = :ingredient_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':line_id', $lineId, PDO::PARAM_INT);
        $stmt->bindValue(':ingredient_id', $ingredientId, PDO::PARAM_INT);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    /**
     * Remove all ingredients from an order line
     */
    public function removeAllIngredientsFromOrderLine(int $lineId): bool
    {
        $this->conn = $this->db->connect();

        $query = "DELETE FROM order_line_ingredient WHERE id_line = :line_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':line_id', $lineId, PDO::PARAM_INT);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    /**
     * Remove all extra ingredients from an order line
     */
    public function removeExtraIngredientsFromOrderLine(int $lineId): bool
    {
        $this->conn = $this->db->connect();

        $query = "DELETE FROM order_line_ingredient 
                WHERE id_line = :line_id AND origin = 'extra'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':line_id', $lineId, PDO::PARAM_INT);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }
}
