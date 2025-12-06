<?php

class ProductIngredient
{
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_product;
    
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_ingredient;
    
    /** DECIMAL(10,2) NOT NULL */
    private float $grams_per_portion;
    
    /** DECIMAL(10,2) NOT NULL */
    private float $portion_price;
    
    /** TINYINT(1) NOT NULL DEFAULT 0 */
    private bool $is_default;
    
    /** Runtime flag: selected in client's final product (not in DB) */
    private bool $is_in_final_product;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_product = (int)($data['id_product'] ?? 0);
            $this->id_ingredient = (int)($data['id_ingredient'] ?? 0);
            $this->grams_per_portion = (float)($data['grams_per_portion'] ?? 0.0);
            $this->portion_price = (float)($data['portion_price'] ?? 0.0);
            $this->is_default = (bool)($data['is_default'] ?? false);
            
            $inFinal = $data['is_in_final_product'] ?? null;
            $this->is_in_final_product = ($inFinal !== null) ? (bool)$inFinal : $this->is_default;
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

    public function getIsInFinalProduct()
    {
        return $this->is_in_final_product;
    }
    public function setIsInFinalProduct($v)
    {
        $this->is_in_final_product = $v;
        return $this;
    }
}