<?php

class OrderLine
{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private int $id_line;
    
    /** BIGINT UNSIGNED NOT NULL */
    private int $id_order;
    
    /** BIGINT UNSIGNED NOT NULL */
    private int $id_product;
    
    /** INT UNSIGNED NOT NULL */
    private int $quantity;
    
    /** DECIMAL(10,2) NOT NULL */
    private float $unit_price;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_line = (int)($data['id_line'] ?? $data['id'] ?? 0);
            $this->id_order = (int)($data['id_order'] ?? 0);
            $this->id_product = (int)($data['id_product'] ?? 0);
            $this->quantity = (int)($data['quantity'] ?? 0);
            $this->unit_price = (float)($data['unit_price'] ?? 0.0);
        }
    }

    public function getId()
    {
        return $this->id_line;
    }

    public function setId($id)
    {
        $this->id_line = $id;
        return $this;
    }

    public function getOrderId()
    {
        return $this->id_order;
    }
    public function setOrderId($id)
    {
        $this->id_order = $id;
        return $this;
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

    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($q)
    {
        $this->quantity = $q;
        return $this;
    }

    public function getUnitPrice()
    {
        return $this->unit_price;
    }
    public function setUnitPrice($p)
    {
        $this->unit_price = $p;
        return $this;
    }
}