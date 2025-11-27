<?php

class Ingredient
{
    private $id_ingredient;
    private $name;
    private $category;
    private $description;
    private $price_per_100g;
    private $kcal_per_100g;
    private $has_doneness;
    private $country;
    private $available;
    private $created_at;
    private $updated_at;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_ingredient = $data['id_ingredient'] ?? $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->category = $data['category'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->price_per_100g = $data['price_per_100g'] ?? $data['pricePer100g'] ?? null;
            $this->kcal_per_100g = $data['kcal_per_100g'] ?? $data['kcalPer100g'] ?? null;
            $this->has_doneness = $data['has_doneness'] ?? $data['has_doneness'] ?? null;
            $this->country = $data['country'] ?? null;
            $this->available = $data['available'] ?? $data['avaliable'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
        }
    }

    public function getId()
    {
        return $this->id_ingredient;
    }
    public function setId($id)
    {
        $this->id_ingredient = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }
    public function setCategory($category)
    {
        $this->category = $category;
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

    public function getPricePer100g()
    {
        return $this->price_per_100g;
    }
    public function setPricePer100g($price)
    {
        $this->price_per_100g = $price;
        return $this;
    }

    public function getKcalPer100g()
    {
        return $this->kcal_per_100g;
    }
    public function setKcalPer100g($kcal)
    {
        $this->kcal_per_100g = $kcal;
        return $this;
    }

    public function getHasDoneness()
    {
        return $this->has_doneness;
    }
    public function setHasDoneness($val)
    {
        $this->has_doneness = $val;
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getAvailable()
    {
        return $this->available;
    }
    public function setAvailable($available)
    {
        $this->available = $available;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}