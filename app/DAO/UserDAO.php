<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'User.php';

class UserDAO
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new DatabasePDO();
    }

    /**
     * Get a user by its primary id
     */
    public function getUserById(int $id)
    {
        $users = $this->getUsersByFilter(['id' => $id]);
        return count($users) ? $users[0] : null;
    }

    /**
     * Get a user by username
     */
    public function getUserByUsername(string $username)
    {
        $users = $this->getUsersByFilter(['username' => $username]);
        return count($users) ? $users[0] : null;
    }

    /**
     * Get a user by email
     */
    public function getUserByEmail(string $email)
    {
        $users = $this->getUsersByFilter(['email' => $email]);
        return count($users) ? $users[0] : null;
    }

    /**
     * Generic filter for users. Supported filters:
     *  - id (int or array)
     *  - username (string)
     *  - email (string)
     *  - role (string)
     */
    public function getUsersByFilter(array $filters = [], ?string $orderBy = null)
    {
        $this->conn = $this->db->connect();

        $params = [];
        $wheres = [];
        $sql = 'SELECT * FROM user';

        if (isset($filters['id'])) {
            if (is_array($filters['id'])) {
                $placeholders = [];
                foreach ($filters['id'] as $i => $val) {
                    $ph = ':id_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = (int)$val;
                }
                $wheres[] = 'id_user IN (' . implode(',', $placeholders) . ')';
            } else {
                $wheres[] = 'id_user = :id_user';
                $params[':id_user'] = (int)$filters['id'];
            }
        }

        if (isset($filters['username'])) {
            $wheres[] = 'username = :username';
            $params[':username'] = $filters['username'];
        }

        if (isset($filters['email'])) {
            $wheres[] = 'email = :email';
            $params[':email'] = $filters['email'];
        }

        if (isset($filters['role'])) {
            $wheres[] = 'role = :role';
            $params[':role'] = $filters['role'];
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

        $usersList = [];
        foreach ($results as $row) {
            $usersList[] = new User($row);
        }

        return $usersList;
    }

    // CREATE METHOD
    /**
     * Create a new user. Optionally pass a plain password which will be hashed.
     * Returns inserted id or false on failure.
     */
    public function createUser(User $user, ?string $plainPassword = null)
    {
        $this->conn = $this->db->connect();

        if ($plainPassword !== null) {
            $user->setAndHashPassword($plainPassword);
        }

        $query = "INSERT INTO user (id_user_type, username, role, email, password_hash, first_name, last_name, phone, address, birth_date, registered_at)
            VALUES (:id_user_type, :username, :role, :email, :password_hash, :first_name, :last_name, :phone, :address, :birth_date, :registered_at)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_user_type', $user->getUserTypeId(), PDO::PARAM_INT);
        $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':role', $user->getRole(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $user->getPasswordHash(), PDO::PARAM_STR);
        $stmt->bindValue(':first_name', $user->getFirstName(), PDO::PARAM_STR);

        // nullable fields: bind NULL explicitly when model has null
        if ($user->getLastName() === null) {
            $stmt->bindValue(':last_name', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':last_name', $user->getLastName(), PDO::PARAM_STR);
        }

        if ($user->getPhone() === null) {
            $stmt->bindValue(':phone', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':phone', $user->getPhone(), PDO::PARAM_STR);
        }

        if ($user->getAddress() === null) {
            $stmt->bindValue(':address', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':address', json_encode($user->getAddress()), PDO::PARAM_STR);
        }

        if ($user->getBirthDate() === null) {
            $stmt->bindValue(':birth_date', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':birth_date', $user->getBirthDate(), PDO::PARAM_STR);
        }

        $stmt->bindValue(':registered_at', $user->getRegisteredAt(), PDO::PARAM_STR);

        $stmt->execute();
        $id = $this->conn->lastInsertId();

        // If insert succeeded, set the id back on the model for caller convenience
        if ($id) {
            $user->setId((int)$id);
        }

        $this->db->disconnect();

        return $id ? (int)$id : false;
    }

    // UPDATE METHOD
    /**
     * Update an existing user record from the provided User model.
     * Returns true if rows were affected.
     */
    public function updateUser(User $user): bool
    {
        $this->conn = $this->db->connect();
        $id = $user->getId();
        if (empty($id) || (int)$id <= 0) {
            $this->db->disconnect();
            return false;
        }
        $id = (int)$id;
        $fields = [];
        $params = [':id_user' => $id];

        $fields[] = 'id_user_type = :id_user_type';
        $params[':id_user_type'] = $user->getUserTypeId();

        $fields[] = 'username = :username';
        $params[':username'] = $user->getUsername();

        $fields[] = 'role = :role';
        $params[':role'] = $user->getRole();

        $fields[] = 'email = :email';
        $params[':email'] = $user->getEmail();

        $fields[] = 'password_hash = :password_hash';
        $params[':password_hash'] = $user->getPasswordHash();

        $fields[] = 'first_name = :first_name';
        $params[':first_name'] = $user->getFirstName();

        $fields[] = 'last_name = :last_name';
        $params[':last_name'] = $user->getLastName();

        $fields[] = 'phone = :phone';
        $params[':phone'] = $user->getPhone();

        $fields[] = 'address = :address';
        $params[':address'] = $user->getAddress() ? json_encode($user->getAddress()) : null;

        $fields[] = 'birth_date = :birth_date';
        $params[':birth_date'] = $user->getBirthDate();

        $query = 'UPDATE user SET ' . implode(', ', $fields) . ' WHERE id_user = :id_user';
        $stmt = $this->conn->prepare($query);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        $updated = $stmt->rowCount() > 0;

        $this->db->disconnect();

        return $updated;
    }

    // DELETE METHOD
    /**
     * Delete user by id
     */
    public function deleteUser(int $id): bool
    {
        $this->conn = $this->db->connect();

        $query = 'DELETE FROM user WHERE id_user = :id_user';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_user', $id, PDO::PARAM_INT);
        $stmt->execute();
        $deleted = $stmt->rowCount() > 0;

        $this->db->disconnect();

        return $deleted;
    }

    //HELPER METHODS
    /**
     * Authenticate a user by username or email and plain password.
     * Returns the User on success, null on failure.
     */
    public function authenticate(string $identifier, string $password)
    {
        $user = $this->getUserByUsername($identifier);
        if (!$user) {
            $user = $this->getUserByEmail($identifier);
        }
        if (!$user) return null;

        if ($user->verifyPassword($password)) {
            return $user;
        }

        return null;
    }

    /**
     * Convenience checks
     */
    public function existsByUsername(string $username): bool
    {
        $this->conn = $this->db->connect();
        $query = 'SELECT COUNT(*) as cnt FROM user WHERE username = :username';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->db->disconnect();
        return $row && $row['cnt'] > 0;
    }

    public function existsByEmail(string $email): bool
    {
        $this->conn = $this->db->connect();
        $query = 'SELECT COUNT(*) as cnt FROM user WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->db->disconnect();
        return $row && $row['cnt'] > 0;
    }
}
