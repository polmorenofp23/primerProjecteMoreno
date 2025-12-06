<?php

class UserType {
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private int $id_user_type;
    
    /** VARCHAR(80) NOT NULL */
    private string $name;
    
    /** VARCHAR(255) NULL */
    private ?string $description = null;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_user_type = isset($data['id_user_type']) ? (int)$data['id_user_type'] : 0;
            $this->name = (string)($data['name'] ?? '');
            $this->description = isset($data['description']) ? (string)$data['description'] : null;
        }
    }

    public function getId()
    {
        return $this->id_user_type;
    }

    public function setId($id)
    {
        $this->id_user_type = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}