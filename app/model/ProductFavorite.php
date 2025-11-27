<?php

class ProductFavorite
{
    private $id_user;
    private $id_product;
    private $created_at;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_user = $data['id_user'] ?? null;
            $this->id_product = $data['id_product'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
        }
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

    public function getProductId()
    {
        return $this->id_product;
    }
    public function setProductId($id)
    {
        $this->id_product = $id;
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
}
