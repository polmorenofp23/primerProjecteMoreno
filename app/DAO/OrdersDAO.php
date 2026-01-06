<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'Orders.php';

class OrdersDAO
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabasePDO();
    }

    /**
     * Get an order by its primary id
     */
    public function getOrderById(int $id)
    {
        $orders = $this->getOrdersByFilter(['id' => $id]);
        return count($orders) ? $orders[0] : null;
    }

    /**
     * Get all orders for a specific user
     */
    public function getOrdersByUserId(int $userId)
    {
        return $this->getOrdersByFilter(['user_id' => $userId]);
    }

    /**
     * Generic filter for orders. Supported filters:
     *  - id (int or array)
     *  - user_id (int)
     *  - table_id (int)
     *  - order_status (string or array)
     *  - payment_status (string or array)
     *  - date_from (string datetime)
     *  - date_to (string datetime)
     */
    public function getOrdersByFilter(array $filters = [], ?string $orderBy = null)
    {
        $this->conn = $this->db->connect();

        $params = [];
        $wheres = [];
        $sql = 'SELECT * FROM orders';

        // by specific id (accepts single id or array of ids)
        if (isset($filters['id'])) {
            if (is_array($filters['id'])) {
                $placeholders = [];
                foreach ($filters['id'] as $i => $val) {
                    $ph = ':id_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = (int)$val;
                }
                $wheres[] = 'id_order IN (' . implode(',', $placeholders) . ')';
            } else {
                $wheres[] = 'id_order = :id_order';
                $params[':id_order'] = (int)$filters['id'];
            }
        }

        // by user_id
        if (isset($filters['user_id'])) {
            $wheres[] = 'id_user = :id_user';
            $params[':id_user'] = (int)$filters['user_id'];
        }

        // by table_id
        if (isset($filters['table_id'])) {
            $wheres[] = 'table_id = :table_id';
            $params[':table_id'] = (int)$filters['table_id'];
        }

        // by order_status (string or array)
        if (isset($filters['order_status'])) {
            if (is_array($filters['order_status'])) {
                $placeholders = [];
                foreach ($filters['order_status'] as $i => $val) {
                    $ph = ':order_status_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = $val;
                }
                $wheres[] = 'order_status IN (' . implode(',', $placeholders) . ')';
            } else {
                $wheres[] = 'order_status = :order_status';
                $params[':order_status'] = $filters['order_status'];
            }
        }

        // by payment_status (string or array)
        if (isset($filters['payment_status'])) {
            if (is_array($filters['payment_status'])) {
                $placeholders = [];
                foreach ($filters['payment_status'] as $i => $val) {
                    $ph = ':payment_status_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = $val;
                }
                $wheres[] = 'payment_status IN (' . implode(',', $placeholders) . ')';
            } else {
                $wheres[] = 'payment_status = :payment_status';
                $params[':payment_status'] = $filters['payment_status'];
            }
        }

        // by date range
        if (isset($filters['date_from'])) {
            $wheres[] = 'created_at >= :date_from';
            $params[':date_from'] = $filters['date_from'];
        }
        if (isset($filters['date_to'])) {
            $wheres[] = 'created_at <= :date_to';
            $params[':date_to'] = $filters['date_to'];
        }

        // mount the SQL query
        if (!empty($wheres)) {
            $sql .= ' WHERE ' . implode(' AND ', $wheres);
        }

        // ordering
        if ($orderBy) {
            switch ($orderBy) {
                case 'date_asc':
                    $sql .= ' ORDER BY created_at ASC';
                    break;
                case 'date_desc':
                    $sql .= ' ORDER BY created_at DESC';
                    break;
                case 'total_asc':
                    $sql .= ' ORDER BY total_amount ASC';
                    break;
                case 'total_desc':
                    $sql .= ' ORDER BY total_amount DESC';
                    break;
                default:
                    $sql .= ' ORDER BY ' . $orderBy;
                    break;
            }
        } else {
            $sql .= ' ORDER BY created_at DESC';  // Default: most recent first
        }

        // bind all params
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

        $ordersList = [];
        foreach ($results as $result) {
            $ordersList[] = new Orders($result);
        }

        $this->db->disconnect();

        return $ordersList;
    }

    // ----------------- CREATE METHODS -----------------
    /**
     * Create a new order in the database
     * Returns the id of the created order, or false on failure
     */
    public function createOrder(Orders $order)
    {
        $this->conn = $this->db->connect();

        $query = "INSERT INTO orders (id_user, id_discount, total_amount, discount_amount, table_id, order_status, payment_status) 
                VALUES (:id_user, :id_discount, :total_amount, :discount_amount, :table_id, :order_status, :payment_status)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_user', $order->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':id_discount', $order->getDiscountId(), PDO::PARAM_INT);
        $stmt->bindValue(':total_amount', $order->getTotalAmount());
        $stmt->bindValue(':discount_amount', $order->getDiscountAmount());
        $stmt->bindValue(':table_id', $order->getTableId(), PDO::PARAM_INT);
        $stmt->bindValue(':order_status', $order->getOrderStatus());
        $stmt->bindValue(':payment_status', $order->getPaymentStatus());
        $stmt->execute();

        $id = $this->conn->lastInsertId();
        $this->db->disconnect();

        return $id ? (int)$id : false;
    }

    // ----------------- UPDATE METHODS -----------------
    /**
     * Update an order's fields
     */
    public function updateOrder(Orders $order): bool
    {
        $this->conn = $this->db->connect();

        $query = "UPDATE orders SET 
            id_user = :id_user,
            id_discount = :id_discount,
            total_amount = :total_amount,
            discount_amount = :discount_amount,
            table_id = :table_id,
            order_status = :order_status,
            payment_status = :payment_status
            WHERE id_order = :id_order";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_order', $order->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':id_user', $order->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':id_discount', $order->getDiscountId(), PDO::PARAM_INT);
        $stmt->bindValue(':total_amount', $order->getTotalAmount());
        $stmt->bindValue(':discount_amount', $order->getDiscountAmount());
        $stmt->bindValue(':table_id', $order->getTableId(), PDO::PARAM_INT);
        $stmt->bindValue(':order_status', $order->getOrderStatus());
        $stmt->bindValue(':payment_status', $order->getPaymentStatus());
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    /**
     * Update only the order status
     */
    public function updateOrderStatus(int $orderId, string $status): bool
    {
        $this->conn = $this->db->connect();

        $query = "UPDATE orders SET order_status = :order_status WHERE id_order = :id_order";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_order', $orderId, PDO::PARAM_INT);
        $stmt->bindValue(':order_status', $status);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    /**
     * Update only the payment status
     */
    public function updatePaymentStatus(int $orderId, string $status): bool
    {
        $this->conn = $this->db->connect();

        $query = "UPDATE orders SET payment_status = :payment_status WHERE id_order = :id_order";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_order', $orderId, PDO::PARAM_INT);
        $stmt->bindValue(':payment_status', $status);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }

    // ----------------- DELETE METHODS -----------------
    /**
     * Delete an order by id
     */
    public function deleteOrder(int $orderId): bool
    {
        $this->conn = $this->db->connect();

        $query = "DELETE FROM orders WHERE id_order = :id_order";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_order', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        $success = $stmt->rowCount() > 0;
        $this->db->disconnect();

        return $success;
    }
}
