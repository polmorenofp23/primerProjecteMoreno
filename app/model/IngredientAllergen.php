<?php

class IngredientAllergen
{
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_ingredient;
    
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_allergen;

    public function __construct($data = null)
    {
        if ($data) {
            // PK composta - NOT NULL
            $this->id_ingredient = (int)($data['id_ingredient'] ?? 0);
            $this->id_allergen = (int)($data['id_allergen'] ?? 0);
        }
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

    public function getAllergenId()
    {
        return $this->id_allergen;
    }
    public function setAllergenId($id)
    {
        $this->id_allergen = $id;
        return $this;
    }
}