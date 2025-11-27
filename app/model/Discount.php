<?php

class Discount
{
    private $id_discount;
    private $name;
    private $description;
    private $percentage;
    private $status;
    private $type;
    private $discount_code;
    private $start_datetime;
    private $end_datetime;
    private $num_reuses;
    private $img_dir;
    private $id_user_type;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_discount = $data['id_discount'] ?? $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->percentage = $data['percentage'] ?? null;
            $this->status = $data['status'] ?? null;
            $this->type = $data['type'] ?? null;
            $this->discount_code = $data['discount_code'] ?? $data['discountCode'] ?? null;
            $this->start_datetime = $data['start_datetime'] ?? null;
            $this->end_datetime = $data['end_datetime'] ?? null;
            $this->num_reuses = $data['num_reuses'] ?? null;
            $this->img_dir = $data['img_dir'] ?? null;
            $this->id_user_type = $data['id_user_type'] ?? null;
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