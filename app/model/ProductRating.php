<?php

class ProductRating
{
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_user;
    
    /** BIGINT UNSIGNED NOT NULL - PK */
    private int $id_product;
    
    /** TINYINT UNSIGNED NOT NULL - CHECK (rating BETWEEN 1 AND 5) */
    private int $rating;
    
    /** TEXT NULL */
    private ?string $comment = null;
    
    /** DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP */
    private string $created_at;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_user = (int)($data['id_user'] ?? 0);
            $this->id_product = (int)($data['id_product'] ?? 0);
            $this->rating = (int)($data['rating'] ?? 1);
            $this->comment = isset($data['comment']) ? (string)$data['comment'] : null;
            $this->created_at = (string)($data['created_at'] ?? date('Y-m-d H:i:s'));
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