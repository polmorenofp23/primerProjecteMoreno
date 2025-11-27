<?php

class Macronutrient
{
    private $id_macronutrient;
    private $name;
    private $description;
    private $icon_dir;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_macronutrient = $data['id_macronutrient'] ?? $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->icon_dir = $data['icon_dir'] ?? null;
        }
    }

    public function getId()
    {
        return $this->id_macronutrient;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setId($id)
    {
        $this->id_macronutrient = $id;
        return $this;
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