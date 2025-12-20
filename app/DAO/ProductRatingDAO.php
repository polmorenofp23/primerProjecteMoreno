<?php

require_once UTIL_PATH . 'DatabasePDO.php';

class ProductRatingDAO {

    private DatabasePDO $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabasePDO();
    }

    /**
     * Get average rating for a product (1-5)
     */
    public function getProductRatingAverage(int $productId): ?float
    {
        $this->conn = $this->db->connect();

        $sql = 'SELECT AVG(rating) AS avg_rating FROM product_rating WHERE id_product = :product_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        if ($row && $row['avg_rating'] !== null) {
            return round((float)$row['avg_rating'], 1);     // Round to 1 decimal as requestedthe value
        }
        return null;
    }

}
