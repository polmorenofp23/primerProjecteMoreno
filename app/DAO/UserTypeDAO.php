<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'UserType.php';

class UserTypeDAO
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabasePDO();
    }

    /**
     * Get a user type by its primary id
     */
    public function getUserTypeById(int $id): ?UserType
    {
        $types = $this->getUserTypesByFilter(['id' => $id]);
        return count($types) ? $types[0] : null;
    }

    /**
     * Get all user types
     */
    public function getAllUserTypes(): array
    {
        return $this->getUserTypesByFilter();
    }

    /**
     * Generic filter for user types. Supported filters:
     *  - id (int or array)
     *  - name (string)
     */
    public function getUserTypesByFilter(array $filters = [], ?string $orderBy = null): array
    {
        $this->conn = $this->db->connect();

        $params = [];
        $wheres = [];
        $sql = 'SELECT * FROM user_type';

        if (isset($filters['id'])) {
            if (is_array($filters['id'])) {
                $placeholders = [];
                foreach ($filters['id'] as $i => $val) {
                    $ph = ':id_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = (int)$val;
                }
                $wheres[] = 'id_user_type IN (' . implode(',', $placeholders) . ')';
            } else {
                $wheres[] = 'id_user_type = :id_user_type';
                $params[':id_user_type'] = (int)$filters['id'];
            }
        }

        if (isset($filters['name'])) {
            $wheres[] = 'name = :name';
            $params[':name'] = $filters['name'];
        }

        if (!empty($wheres)) {
            $sql .= ' WHERE ' . implode(' AND ', $wheres);
        }

        if ($orderBy) {
            $sql .= ' ORDER BY ' . $orderBy;
        }

        $stmt = $this->conn->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $list = [];
        foreach ($results as $row) {
            $list[] = new UserType($row);
        }
        return $list;
    }

    /* CREATE */
    /**
     * Create a new user type
     */
    public function createUserType(UserType $userType): ?int
    {
        $this->conn = $this->db->connect();

        $sql = 'INSERT INTO user_type (name, description) VALUES (:name, :description)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $userType->getName());
        $stmt->bindValue(':description', $userType->getDescription());

        $success = $stmt->execute();
        if ($success) {
            $createdId = (int)$this->conn->lastInsertId();
            $this->db->disconnect();
            return $createdId;
        } else {
            $this->db->disconnect();
            return null;
        }
    }
}
