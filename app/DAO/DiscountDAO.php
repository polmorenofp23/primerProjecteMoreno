<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'Discount.php';

class DiscountDAO
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabasePDO();
    }

    /**
     * Get discount by ID
     */
    public function getDiscountById(int $id): ?Discount
    {
        $discounts = $this->getDiscountsByFilter(['id' => $id]);
        return !empty($discounts) ? $discounts[0] : null;
    }

    /**
     * Get discount by promo code
     */
    // public function getDiscountByCode(string $code): ?Discount
    // {
    //     $discounts = $this->getDiscountsByFilter(['code' => $code, 'type' => 'promocode', 'status' => 'active']);
    //     return !empty($discounts) ? $discounts[0] : null;
    // }

    /**
     * Get discount by user type ID
     */
    public function getDiscountByUserType(int $userTypeId): ?Discount
    {
        $discounts = $this->getDiscountsByFilter(['user_type_id' => $userTypeId, 'type' => 'user_type', 'status' => 'active']);
        return !empty($discounts) ? $discounts[0] : null;
    }

    /**
     * Get discounts by type
     */
    public function getDiscountsByType(string $type): array
    {
        return $this->getDiscountsByFilter(['type' => $type], 'name ASC');
    }

    /**
     * Get all discounts
     */
    public function getAllDiscounts(): array
    {
        return $this->getDiscountsByFilter([], 'name ASC');
    }


    /**
     * Generic filter for discounts. Supported filters:
     *  - id (int)
     *  - code (string)
     *  - type (string: 'promocode' or 'user_type')
     *  - status (string: 'active' or 'inactive')
     *  - user_type_id (int)
     */
    public function getDiscountsByFilter(array $filters = [], ?string $orderBy = null): array
    {
        $this->conn = $this->db->connect();

        $params = [];
        $wheres = [];
        $sql = 'SELECT * FROM discount';

        if (isset($filters['id'])) {
            $wheres[] = 'id_discount = :id';
            $params[':id'] = (int)$filters['id'];
        }

        // if (isset($filters['code'])) {
        //     $wheres[] = 'discount_code = :code';
        //     $params[':code'] = $filters['code'];
        // }

        if (isset($filters['type'])) {
            $wheres[] = 'type = :type';
            $params[':type'] = $filters['type'];
        }

        if (isset($filters['status'])) {
            $wheres[] = 'status = :status';
            $params[':status'] = $filters['status'];
        }

        if (isset($filters['user_type_id'])) {
            $wheres[] = 'id_user_type = :user_type_id';
            $params[':user_type_id'] = (int)$filters['user_type_id'];
        }

        if (!empty($wheres)) {
            $sql .= ' WHERE ' . implode(' AND ', $wheres);
        }

        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        $stmt = $this->conn->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $discountsList = [];
        foreach ($results as $row) {
            $discountsList[] = new Discount($row);
        }

        return $discountsList;
    }

    /** CREATE */
    /**
     * Create a new discount
     */
    public function createDiscount(Discount $discount): ?int
    {
        $this->conn = $this->db->connect();

        $query = "INSERT INTO discount (name, description, percentage, status, type, discount_code, start_datetime, end_datetime, num_reuses, img_dir, id_user_type)
                 VALUES (:name, :description, :percentage, :status, :type, :code, :start, :end, :reuses, :img, :user_type_id)";

        $stmt = $this->conn->prepare($query);

        $imgDir = $discount->getImgDir() ? json_encode($discount->getImgDir()) : null;

        $stmt->bindValue(':name', $discount->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $discount->getDescription(), $discount->getDescription() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':percentage', $discount->getPercentage(), PDO::PARAM_INT);
        $stmt->bindValue(':status', $discount->getStatus(), PDO::PARAM_STR);
        $stmt->bindValue(':type', $discount->getType(), PDO::PARAM_STR);
        $stmt->bindValue(':code', $discount->getDiscountCode(), $discount->getDiscountCode() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':start', $discount->getStartDatetime(), $discount->getStartDatetime() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':end', $discount->getEndDatetime(), $discount->getEndDatetime() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':reuses', $discount->getNumReuses(), $discount->getNumReuses() === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':img', $imgDir, $imgDir === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':user_type_id', $discount->getUserTypeId(), $discount->getUserTypeId() === null ? PDO::PARAM_NULL : PDO::PARAM_INT);

        $stmt->execute();
        $id = $this->conn->lastInsertId();

        $this->db->disconnect();

        return $id ? (int)$id : null;
    }

    /** UPDATE */
    /**
     * Update a discount
     */
    public function updateDiscount(Discount $discount): bool
    {
        $this->conn = $this->db->connect();

        $query = "UPDATE discount SET 
                 name = :name,
                 description = :description,
                 percentage = :percentage,
                 status = :status,
                 type = :type,
                 discount_code = :code,
                 start_datetime = :start,
                 end_datetime = :end,
                 num_reuses = :reuses,
                 img_dir = :img,
                 id_user_type = :user_type_id
                 WHERE id_discount = :id";

        $stmt = $this->conn->prepare($query);

        $imgDir = $discount->getImgDir() ? json_encode($discount->getImgDir()) : null;

        $stmt->bindValue(':id', $discount->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $discount->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $discount->getDescription(), $discount->getDescription() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':percentage', $discount->getPercentage(), PDO::PARAM_INT);
        $stmt->bindValue(':status', $discount->getStatus(), PDO::PARAM_STR);
        $stmt->bindValue(':type', $discount->getType(), PDO::PARAM_STR);
        $stmt->bindValue(':code', $discount->getDiscountCode(), $discount->getDiscountCode() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':start', $discount->getStartDatetime(), $discount->getStartDatetime() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':end', $discount->getEndDatetime(), $discount->getEndDatetime() === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':reuses', $discount->getNumReuses(), $discount->getNumReuses() === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':img', $imgDir, $imgDir === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':user_type_id', $discount->getUserTypeId(), $discount->getUserTypeId() === null ? PDO::PARAM_NULL : PDO::PARAM_INT);

        $result = $stmt->execute();

        $this->db->disconnect();

        return $result;
    }

    /** DELETE */
    /**
     * Delete a discount
     */
    public function deleteDiscount(int $id): bool
    {
        $this->conn = $this->db->connect();

        $query = "DELETE FROM discount WHERE id_discount = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();

        $this->db->disconnect();

        return $result;
    }
}