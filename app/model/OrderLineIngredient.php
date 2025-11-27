<?php

class OrderLineIngredient
{
    private $id_line;
    private $id_ingredient;
    private $num_portions;
    private $ingredient_price;
    private $grams;
    private $kcal_component;
    private $protein_g;
    private $carbs_g;
    private $fat_g;
    private $origin;
    private $doneness;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_line = $data['id_line'] ?? null;
            $this->id_ingredient = $data['id_ingredient'] ?? null;
            $this->num_portions = $data['num_portions'] ?? null;
            $this->ingredient_price = $data['ingredient_price'] ?? null;
            $this->grams = $data['grams'] ?? null;
            $this->kcal_component = $data['kcal_component'] ?? null;
            $this->protein_g = $data['protein_g'] ?? null;
            $this->carbs_g = $data['carbs_g'] ?? null;
            $this->fat_g = $data['fat_g'] ?? null;
            $this->origin = $data['origin'] ?? null;
            $this->doneness = $data['doneness'] ?? null;
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
        $this->num_portions = $v;
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
