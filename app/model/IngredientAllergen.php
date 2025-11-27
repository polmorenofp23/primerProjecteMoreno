<?php

class IngredientAllergen
{
    private $id_ingredient;
    private $id_allergen;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_ingredient = $data['id_ingredient'] ?? $data['ingredient_id'] ?? null;
            $this->id_allergen = $data['id_allergen'] ?? $data['allergen_id'] ?? null;
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