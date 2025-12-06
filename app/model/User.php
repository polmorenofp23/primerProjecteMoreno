<?php

class User
{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private int $id_user;
    
    /** BIGINT UNSIGNED NOT NULL */
    private int $id_user_type;
    
    /** VARCHAR(60) NOT NULL */
    private string $username;
    
    /** ENUM('client','admin') NOT NULL DEFAULT 'client' */
    private string $role;
    
    /** VARCHAR(120) NOT NULL */
    private string $email;
    
    /** VARCHAR(255) NOT NULL */
    private string $password_hash;
    
    /** VARCHAR(80) NOT NULL */
    private string $first_name;
    
    /** VARCHAR(120) NULL */
    private ?string $last_name = null;
    
    /** VARCHAR(30) NULL */
    private ?string $phone = null;
    
    /** JSON NULL - can be string (JSON) or array (decoded) */
    private ?array $address = null;
    
    /** DATE NULL */
    private ?string $birth_date = null;
    
    /** DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP */
    private string $registered_at;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_user = (int)($data['id_user'] ?? 0);
            $this->id_user_type = (int)($data['id_user_type'] ?? 0);
            $this->username = (string)($data['username'] ?? '');
            $this->role = (string)($data['role'] ?? 'client');
            $this->email = (string)($data['email'] ?? '');
            $this->password_hash = (string)($data['password_hash'] ?? '');
            $this->first_name = (string)($data['first_name'] ?? '');
            $this->last_name = isset($data['last_name']) ? (string)$data['last_name'] : null;
            $this->phone = isset($data['phone']) ? (string)$data['phone'] : null;
            $this->address = isset($data['address']) ? (is_string($data['address']) ? json_decode($data['address'], true) : $data['address']) : null;
            $this->birth_date = isset($data['birth_date']) ? (string)$data['birth_date'] : null;
            $this->registered_at = (string)($data['registered_at'] ?? date('Y-m-d H:i:s'));
        }
    }

    public function getId()
    {
        return $this->id_user;
    }
    public function setId($id)
    {
        $this->id_user = $id;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPasswordHash()
    {
        return $this->password_hash;
    }
    public function setPasswordHash(string $hash)
    {
        $this->password_hash = $hash;
        return $this;
    }

    public function getUserTypeId()
    {
        return $this->id_user_type;
    }
    public function setUserTypeId($id)
    {
        $this->id_user_type = $id;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function getLastName()
    {
        return $this->last_name;
    }
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }
    public function setBirthDate($birth_date)
    {
        $this->birth_date = $birth_date;
        return $this;
    }

    public function getRegisteredAt()
    {
        return $this->registered_at;
    }
    public function setRegisteredAt($registered_at)
    {
        $this->registered_at = $registered_at;
        return $this;
    }

    /* Password helpers */
    /**
     * Set the password from plain text: hashes using PASSWORD_DEFAULT.
     */
    public function setAndHashPassword(string $password): void
    {
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify a plain text password against the stored hash.
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }
}