<?php

class Discount
{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private ?int $id_discount = null;
    
    /** VARCHAR(120) NOT NULL */
    private string $name;
    
    /** TEXT NULL */
    private ?string $description = null;
    
    /** TINYINT(3) UNSIGNED NOT NULL - 0..100 */
    private int $percentage;
    
    /** ENUM('active','inactive') NOT NULL DEFAULT 'active' */
    private string $status;
    
    /** ENUM('promocode','user_type') NOT NULL */
    private string $type;
    
    /** VARCHAR(64) NULL for promocode */
    private ?string $discount_code = null;
    
    /** DATETIME NULL for promocode */
    private ?string $start_datetime = null;
    
    /** DATETIME NULL for promocode */
    private ?string $end_datetime = null;
    
    /** TINYINT(2) UNSIGNED NULL for promocode */
    private ?int $num_reuses = null;
    
    /** JSON NULL - can be string (JSON) or array (decoded) for promocode */
    private ?array $img_dir = null;
    
    /** BIGINT UNSIGNED NULL for user_type*/
    private ?int $id_user_type = null;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_discount = isset($data['id_discount']) ? (int)$data['id_discount'] : null;
            $this->name = (string)($data['name'] ?? '');
            $this->description = isset($data['description']) ? (string)$data['description'] : null;
            $this->percentage = (int)($data['percentage'] ?? 0);
            $this->status = (string)($data['status'] ?? 'active');
            $this->type = (string)($data['type'] ?? '');
            $this->discount_code = isset($data['discount_code']) ? (string)$data['discount_code'] : (isset($data['discountCode']) ? (string)$data['discountCode'] : null);
            $this->start_datetime = isset($data['start_datetime']) ? (string)$data['start_datetime'] : null;
            $this->end_datetime = isset($data['end_datetime']) ? (string)$data['end_datetime'] : null;
            $this->num_reuses = isset($data['num_reuses']) ? (int)$data['num_reuses'] : null;
            $this->img_dir = isset($data['img_dir']) ? (is_string($data['img_dir']) ? json_decode($data['img_dir'], true) : $data['img_dir']) : null;
            $this->id_user_type = isset($data['id_user_type']) ? (int)$data['id_user_type'] : null;
        }
    }

    public function getId()
    {
        return $this->id_discount;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setId($id)
    {
        $this->id_discount = $id;
        return $this;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getPercentage()
    {
        return $this->percentage;
    }
    public function setPercentage($p)
    {
        $this->percentage = $p;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($s)
    {
        $this->status = $s;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
    public function setType($t)
    {
        $this->type = $t;
        return $this;
    }

    public function getDiscountCode()
    {
        return $this->discount_code;
    }
    public function setDiscountCode($code)
    {
        $this->discount_code = $code;
        return $this;
    }

    public function getStartDatetime()
    {
        return $this->start_datetime;
    }
    public function setStartDatetime($v)
    {
        $this->start_datetime = $v;
        return $this;
    }

    public function getEndDatetime()
    {
        return $this->end_datetime;
    }
    public function setEndDatetime($v)
    {
        $this->end_datetime = $v;
        return $this;
    }

    public function getNumReuses()
    {
        return $this->num_reuses;
    }
    public function setNumReuses($n)
    {
        $this->num_reuses = $n;
        return $this;
    }

    public function getImgDir()
    {
        return $this->img_dir;
    }
    public function setImgDir($d)
    {
        $this->img_dir = $d;
        return $this;
    }

    public function getUserTypeId()
    {
        return $this->id_user_type;
    }
    public function setUserTypeId($id)
    {
        $this->id_user_type = $id;
        return $this;
    }
}