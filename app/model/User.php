<?php

class User
{
    private $id_user;
    private $id_user_type;
    private $username;
    private $role;
    private $email;
    private $password_hash;
    private $first_name;
    private $last_name;
    private $phone;
    private $address; // JSON
    private $birth_date;
    private $registered_at;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_user = $data['id_user'] ?? $data['id'] ?? null;
            $this->id_user_type = $data['id_user_type'] ?? $data['id_user_type'] ?? null;
            $this->username = $data['username'] ?? null;
            $this->role = $data['role'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->password_hash = $data['password_hash'] ?? $data['password'] ?? null;
            $this->first_name = $data['first_name'] ?? null;
            $this->last_name = $data['last_name'] ?? null;
            $this->phone = $data['phone'] ?? null;
            $this->address = $data['address'] ?? null;
            $this->birth_date = $data['birth_date'] ?? null;
            $this->registered_at = $data['registered_at'] ?? $data['registeredAt'] ?? null;
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
    public function setPasswordHash($hash)
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
}