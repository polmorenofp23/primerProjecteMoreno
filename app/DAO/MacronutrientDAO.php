<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'Macronutrient.php';

class MacronutrientDAO{

    private $db;
    private $conn;

    public function __construct(){
        $this->db = new DatabasePDO();
    }

    /**
     * Get a macronutrient by its id
     */
    public function getMacronutrientById(int $id)
    {
        $this->conn = $this->db->connect();
        
        $query = "SELECT * FROM macronutrient WHERE id_macronutrient = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->db->disconnect();

        if (!$result) return null;
        return new Macronutrient($result);
    }

    /**
     * Get all macronutrients from the database
     */
    public function getAllMacronutrients()
    {
        $this->conn = $this->db->connect();
        
        $query = "SELECT * FROM macronutrient";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->db->disconnect();

        $macronutrientsList = [];
        foreach ($results as $result) {
            $macronutrientsList[] = new Macronutrient($result);
        }

        return $macronutrientsList;
    }
}
