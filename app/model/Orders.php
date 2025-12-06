<?php

class Orders
{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private int $id_order;
    
    /** BIGINT UNSIGNED NOT NULL */
    private int $id_user;
    
    /** BIGINT UNSIGNED NULL */
    private ?int $id_discount = null;
    
    /** DECIMAL(10,2) NOT NULL DEFAULT 0.00 */
    private float $total_amount;
    
    /** DECIMAL(10,2) NOT NULL DEFAULT 0.00 */
    private float $discount_amount;
    
    /** INT UNSIGNED NULL */
    private ?int $table_id = null;
    
    /** ENUM('pending','cancelled','confirmed','in-preparation','served') NOT NULL DEFAULT 'pending' */
    private string $order_status;
    
    /** ENUM('pending','rejected','cancelled','paid') NOT NULL DEFAULT 'pending' */
    private string $payment_status;
    
    /** DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP */
    private string $created_at;
    
    /** DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE */
    private string $updated_at;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_order = (int)($data['id_order'] ?? 0);
            $this->id_user = (int)($data['id_user'] ?? 0);
            $this->id_discount = isset($data['id_discount']) ? (int)$data['id_discount'] : null;
            $this->total_amount = (float)($data['total_amount'] ?? 0.0);
            $this->discount_amount = (float)($data['discount_amount'] ?? 0.0);
            $this->table_id = isset($data['table_id']) ? (int)$data['table_id'] : null;
            $this->order_status = (string)($data['order_status'] ?? 'pending');
            $this->payment_status = (string)($data['payment_status'] ?? 'pending');
            $this->created_at = (string)($data['created_at'] ?? date('Y-m-d H:i:s'));
            $this->updated_at = (string)($data['updated_at'] ?? date('Y-m-d H:i:s'));
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