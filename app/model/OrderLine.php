<?php

class OrderLine
{
    private $id_line;
    private $id_order;
    private $id_product;
    private $quantity;
    private $unit_price;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_line = $data['id_line'] ?? $data['id'] ?? null;
            $this->id_order = $data['id_order'] ?? null;
            $this->id_product = $data['id_product'] ?? null;
            $this->quantity = $data['quantity'] ?? null;
            $this->unit_price = $data['unit_price'] ?? null;
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