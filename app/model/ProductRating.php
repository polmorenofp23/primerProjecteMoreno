<?php

class ProductRating
{
    private $id_user;
    private $id_product;
    private $rating;
    private $comment;
    private $created_at;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_user = $data['id_user'] ?? null;
            $this->id_product = $data['id_product'] ?? null;
            $this->rating = $data['rating'] ?? null;
            $this->comment = $data['comment'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
        }
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($r)
    {
        $this->rating = $r;
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

    public function getProductId()
    {
        return $this->id_product;
    }
    public function setProductId($id)
    {
        $this->id_product = $id;
        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }
    public function setComment($c)
    {
        $this->comment = $c;
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