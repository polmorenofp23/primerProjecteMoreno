<?php

class IngredientMacronutrient
{
    private $id_ingredient;
    private $id_macronutrient;
    private $grams_per_100g;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_ingredient = $data['id_ingredient'] ?? null;
            $this->id_macronutrient = $data['id_macronutrient'] ?? null;
            $this->grams_per_100g = $data['grams_per_100g'] ?? $data['gramsPer100g'] ?? null;
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

    public function getMacronutrientId()
    {
        return $this->id_macronutrient;
    }
    public function setMacronutrientId($id)
    {
        $this->id_macronutrient = $id;
        return $this;
    }

    public function getGramsPer100g()
    {
        return $this->grams_per_100g;
    }
    public function setGramsPer100g($v)
    {
        $this->grams_per_100g = $v;
        return $this;
    }
}