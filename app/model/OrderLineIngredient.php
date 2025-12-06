<?php

class OrderLineIngredient
{
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_line;
    
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_ingredient;
    
    /** TINYINT UNSIGNED NOT NULL (1..99) */
    private int $num_portions;
    
    /** DECIMAL(12,4) NOT NULL */
    private float $ingredient_price;
    
    /** DECIMAL(10,2) NOT NULL */
    private float $grams;
    
    /** DECIMAL(12,2) NOT NULL */
    private float $kcal_component;
    
    /** DECIMAL(12,2) NOT NULL */
    private float $protein_g;
    
    /** DECIMAL(12,2) NOT NULL */
    private float $carbs_g;
    
    /** DECIMAL(12,2) NOT NULL */
    private float $fat_g;
    
    /** ENUM('default','extra') NOT NULL */
    private string $origin;
    
    /** ENUM('rare','medium-rare','medium-well','overcooked') NULL DEFAULT 'medium-rare' */
    private ?string $doneness = null;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_line = (int)($data['id_line'] ?? 0);
            $this->id_ingredient = (int)($data['id_ingredient'] ?? 0);
            $this->num_portions = (int)($data['num_portions'] ?? 0);
            $this->ingredient_price = (float)($data['ingredient_price'] ?? 0.0);
            $this->grams = (float)($data['grams'] ?? 0.0);
            $this->kcal_component = (float)($data['kcal_component'] ?? 0.0);
            $this->protein_g = (float)($data['protein_g'] ?? 0.0);
            $this->carbs_g = (float)($data['carbs_g'] ?? 0.0);
            $this->fat_g = (float)($data['fat_g'] ?? 0.0);
            $this->origin = (string)($data['origin'] ?? 'undefined');
            $this->doneness = isset($data['doneness']) ? (string)$data['doneness'] : null;
        }
    }

    public function getLineId()
    {
        return $this->id_line;
    }

    public function setLineId($id)
    {
        $this->id_line = $id;
        return $this;
    }

    public function getIngredientId()
    {
        return $this->id_ingredient;
    }
    public function setIngredientId($id)
    {
        $this->id_ingredient = $id;
        return $this;
    }

    public function getNumPortions()
    {
        return $this->num_portions;
    }
    public function setNumPortions($v)
    {
        $this->num_portions = (int)$v;
        return $this;
    }

    public function getIngredientPrice()
    {
        return $this->ingredient_price;
    }
    public function setIngredientPrice($v)
    {
        $this->ingredient_price = $v;
        return $this;
    }

    public function getGrams()
    {
        return $this->grams;
    }
    public function setGrams($v)
    {
        $this->grams = $v;
        return $this;
    }

    public function getKcalComponent()
    {
        return $this->kcal_component;
    }
    public function setKcalComponent($v)
    {
        $this->kcal_component = $v;
        return $this;
    }

    public function getProteinG()
    {
        return $this->protein_g;
    }
    public function setProteinG($v)
    {
        $this->protein_g = $v;
        return $this;
    }

    public function getCarbsG()
    {
        return $this->carbs_g;
    }
    public function setCarbsG($v)
    {
        $this->carbs_g = $v;
        return $this;
    }

    public function getFatG()
    {
        return $this->fat_g;
    }
    public function setFatG($v)
    {
        $this->fat_g = $v;
        return $this;
    }

    public function getOrigin()
    {
        return $this->origin;
    }
    public function setOrigin($v)
    {
        $this->origin = $v;
        return $this;
    }

    public function getDoneness()
    {
        return $this->doneness;
    }
    public function setDoneness($v)
    {
        $this->doneness = $v;
        return $this;
    }
}
