<?php

class Allergen{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private ?int $id_allergen = null;
    
    /** VARCHAR(80) NOT NULL */
    private string $name;
    
    /** VARCHAR(255) NULL */
    private ?string $description = null;
    
    /** JSON NOT NULL - can be string (JSON) or array (decoded) */
    private array $icon_dir;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_allergen = isset($data['id_allergen']) ? (int)$data['id_allergen'] : null;
            $this->name = (string)($data['name'] ?? '');
            $this->description = isset($data['description']) ? (string)$data['description'] : null;
            $this->icon_dir = isset($data['icon_dir']) ? (is_string($data['icon_dir']) ? json_decode($data['icon_dir'], true) : $data['icon_dir']) : [];
        }
    }

    public function getId()
    {
        return $this->id_allergen;
    }
    public function setId($id)
    {
        $this->id_allergen = $id;
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

    public function getIconDir()
    {
        return $this->icon_dir;
    }
    public function setIconDir($icon_dir)
    {
        $this->icon_dir = $icon_dir;
        return $this;
    }
}