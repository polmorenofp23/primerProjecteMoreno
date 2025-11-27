<?php

class Orders
{
    private $id_order;
    private $id_user;
    private $id_discount;
    private $total_amount;
    private $discount_amount;
    private $table_id;
    private $order_status;
    private $payment_status;
    private $created_at;
    private $updated_at;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_order = $data['id_order'] ?? $data['id'] ?? null;
            $this->id_user = $data['id_user'] ?? null;
            $this->id_discount = $data['id_discount'] ?? null;
            $this->total_amount = $data['total_amount'] ?? null;
            $this->discount_amount = $data['discount_amount'] ?? null;
            $this->table_id = $data['table_id'] ?? null;
            $this->order_status = $data['order_status'] ?? null;
            $this->payment_status = $data['payment_status'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
        }
    }

    public function getId()
    {
        return $this->id_order;
    }

    public function setId($id)
    {
        $this->id_order = $id;
        return $this;
    }

    public function getUserId()
    {
        return $this->id_user;
    }
    public function setUserId($id)
    {
        $this->id_user = $id;
        return $this;
    }

    public function getDiscountId()
    {
        return $this->id_discount;
    }
    public function setDiscountId($id)
    {
        $this->id_discount = $id;
        return $this;
    }

    public function getTotalAmount()
    {
        return $this->total_amount;
    }
    public function setTotalAmount($v)
    {
        $this->total_amount = $v;
        return $this;
    }

    public function getDiscountAmount()
    {
        return $this->discount_amount;
    }
    public function setDiscountAmount($v)
    {
        $this->discount_amount = $v;
        return $this;
    }

    public function getTableId()
    {
        return $this->table_id;
    }
    public function setTableId($v)
    {
        $this->table_id = $v;
        return $this;
    }

    public function getOrderStatus()
    {
        return $this->order_status;
    }
    public function setOrderStatus($s)
    {
        $this->order_status = $s;
        return $this;
    }

    public function getPaymentStatus()
    {
        return $this->payment_status;
    }
    public function setPaymentStatus($s)
    {
        $this->payment_status = $s;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function setCreatedAt($v)
    {
        $this->created_at = $v;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function setUpdatedAt($v)
    {
        $this->updated_at = $v;
        return $this;
    }
}