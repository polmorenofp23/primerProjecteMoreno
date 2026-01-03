<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'OrderLine.php';
require_once DAO_PATH . 'OrderLineIngredientDAO.php';

class OrderLineDAO
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabasePDO();
    }

    /**
     * Get an order line by its primary id
     */
    public function getOrderLineById(int $id)
    {
        $lines = $this->getOrderLinesByFilter(['id' => $id]);
        return count($lines) ? $lines[0] : null;
    }

    /**
     * Get all order lines for a specific order
     */
    public function getOrderLinesByOrderId(int $orderId)
    {
        return $this->getOrderLinesByFilter(['order_id' => $orderId]);
    }

    /**
     * Generic filter for order lines. Supported filters:
     *  - id (int or array)
     *  - order_id (int or array)
     *  - product_id (int or array)
     */
    public function getOrderLinesByFilter(array $filters = [], ?string $orderBy = null)
    {
        $this->conn = $this->db->connect();

        $params = [];
        $wheres = [];
        $sql = 'SELECT * FROM order_line';

        // by line id
        if (isset($filters['id'])) {
            if (is_array($filters['id'])) {
                $placeholders = [];
                foreach ($filters['id'] as $i => $val) {
                    $ph = ':id_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = (int)$val;
                }
                $wheres[] = 'id_line IN (' . implode(',', $placeholders) . ')';
            } else {
                $wheres[] = 'id_line = :id_line';
                $params[':id_line'] = (int)$filters['id'];
            }
        }

        // by order_id
        if (isset($filters['order_id'])) {
            if (is_array($filters['order_id'])) {
                $placeholders = [];
                foreach ($filters['order_id'] as $i => $val) {
                    $ph = ':order_id_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = (int)$val;
                }
                $wheres[] = 'id_order IN (' . implode(',', $placeholders) . ')';
            } else {
                $wheres[] = 'id_order = :id_order';
                $params[':id_order'] = (int)$filters['order_id'];
            }
        }

        // by product_id
        if (isset($filters['product_id'])) {
            if (is_array($filters['product_id'])) {
                $placeholders = [];
                foreach ($filters['product_id'] as $i => $val) {
                    $ph = ':product_id_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = (int)$val;
                }
                $wheres[] = 'id_product IN (' . implode(',', $placeholders) . ')';
            } else {
                $wheres[] = 'id_product = :id_product';
                $params[':id_product'] = (int)$filters['product_id'];
            }
        }

        if (!empty($wheres)) {
            $sql .= ' WHERE ' . implode(' AND ', $wheres);
        }

        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        $stmt = $this->conn->prepare($sql);
        foreach ($params as $k => $v) {
            if (is_int($v)) {
                $stmt->bindValue($k, $v, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($k, $v, PDO::PARAM_STR);
            }
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orderLinesList = [];
        $oliDao = new OrderLineIngredientDAO();
        foreach ($results as $result) {
            $orderLine = new OrderLine($result);
            $ingredients = $oliDao->getIngredientsByOrderLine((int)$orderLine->getId());
            $orderLine->setIngredients($ingredients);
            $orderLinesList[] = $orderLine;
        }

        $this->db->disconnect();

        return $orderLinesList;
    }

    // ----------------- CREATE METHODS -----------------
    /**
     * Create a new order line in the database
     * Returns the id of the created order line, or false on failure
     */
    public function createOrderLine(OrderLine $orderLine)
    {
        $this->conn = $this->db->connect();

        $query = "INSERT INTO order_line (id_order, id_product, quantity, unit_price) 
                VALUES (:id_order, :id_product, :quantity, :unit_price)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_order', $orderLine->getOrderId(), PDO::PARAM_INT);
        $stmt->bindValue(':id_product', $orderLine->getProductId(), PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $orderLine->getQuantity(), PDO::PARAM_INT);
        $stmt->bindValue(':unit_price', $orderLine->getUnitPrice());
        $stmt->execute();

        $id = $this->conn->lastInsertId();
        $this->db->disconnect();

        return $id ? (int)$id : false;
    }

    // ----------------- UPDATE METHODS -----------------
    /**
     * Update an order line's fields
     * Returns true if updated, false otherwise
     */
    public function updateOrderLine(OrderLine $orderLine): bool
    {
        $this->conn = $this->db->connect();

        $query = "UPDATE order_line SET 
            id_order = :id_order,
            id_product = :id_product,
            quantity = :quantity,
            unit_price = :unit_price
            WHERE id_line = :id_line";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_line', $orderLine->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':id_order', $orderLine->getOrderId(), PDO::PARAM_INT);
        $stmt->bindValue(':id_product', $orderLine->getProductId(), PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $orderLine->getQuantity(), PDO::PARAM_INT);
        $stmt->bindValue(':unit_price', $orderLine->getUnitPrice());
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    /**
     * Update only the quantity of an order line
     */
    public function updateQuantity(int $lineId, int $quantity): bool
    {
        $this->conn = $this->db->connect();

        $query = "UPDATE order_line SET quantity = :quantity WHERE id_line = :id_line";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_line', $lineId, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    // ----------------- DELETE METHODS -----------------
    /**
     * Delete an order line by id
     * Note: This should also delete all related order_line_ingredient entries (cascade)
     */
    public function deleteOrderLine(int $lineId): bool
    {
        $this->conn = $this->db->connect();

        $query = "DELETE FROM order_line WHERE id_line = :id_line";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_line', $lineId, PDO::PARAM_INT);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    /**
     * Delete all order lines for a specific order
     */
    public function deleteOrderLinesByOrderId(int $orderId): bool
    {
        $this->conn = $this->db->connect();

        $query = "DELETE FROM order_line WHERE id_order = :id_order";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_order', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }
}
