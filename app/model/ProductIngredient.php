<?php

class ProductIngredient
{
    private $id_product;
    private $id_ingredient;
    private $grams_per_portion;
    private $portion_price;
    private $is_default;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_product = $data['id_product'] ?? null;
            $this->id_ingredient = $data['id_ingredient'] ?? null;
            $this->grams_per_portion = $data['grams_per_portion'] ?? null;
            $this->portion_price = $data['portion_price'] ?? null;
            $this->is_default = $data['is_default'] ?? $data['isDefault'] ?? null;
        }
    }

    public function getProductId()
    {
        return $this->id_product;
    }

    public function setProductId($id)
    {
        $this->id_product = $id;
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

    public function getGramsPerPortion()
    {
        return $this->grams_per_portion;
    }
    public function setGramsPerPortion($v)
    {
        $this->grams_per_portion = $v;
        return $this;
    }

    public function getPortionPrice()
    {
        return $this->portion_price;
    }
    public function setPortionPrice($v)
    {
        $this->portion_price = $v;
        return $this;
    }

    public function getIsDefault()
    {
        return $this->is_default;
    }
    public function setIsDefault($v)
    {
        $this->is_default = $v;
        return $this;
    }
}