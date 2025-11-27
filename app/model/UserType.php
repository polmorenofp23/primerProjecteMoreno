<?php

class UserType {
    private $id_user_type;
    private $name;
    private $description;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_user_type = $data['id_user_type'] ?? $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->description = $data['description'] ?? null;
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