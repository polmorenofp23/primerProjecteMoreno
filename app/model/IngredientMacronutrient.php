<?php

class IngredientMacronutrient
{
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_ingredient;
    
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_macronutrient;
    
    /** DECIMAL(10,3) NOT NULL */
    private float $grams_per_100g;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_ingredient = (int)($data['id_ingredient'] ?? 0);
            $this->id_macronutrient = (int)($data['id_macronutrient'] ?? 0);
            $this->grams_per_100g = (float)($data['grams_per_100g'] ?? 0.0);
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