<?php

require_once MODEL_PATH . 'IngredientMacronutrient.php';
require_once MODEL_PATH . 'IngredientAllergen.php';

enum IngredientCategory: string {
    case VEGETABLE = 'vegetable';
    case FRUIT = 'fruit';
    case MEAT = 'meat';
    case FISH = 'fish';
    case SEAFOOD = 'seafood';
    case ANIMAL_DERIVATIVE = 'animal_derivative';
    case TREE_NUT = 'tree_nut';
    case SPICE = 'spice';
    case SWEETENER = 'sweetener';
    case CONDIMENT = 'condiment';
    case NATURAL_FAT = 'natural_fat';
    case DRINK = 'drink';
    case UNDEFINED = 'undefined';
}

class Ingredient
{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private int $id_ingredient;
    
    /** VARCHAR(120) NOT NULL */
    private string $name;
    
    /** ENUM('vegetable','fruit','meat','fish','seafood','animal_derivative','tree_nut','spice','sweetener','condiment','natural_fat','drink') NOT NULL */
    private IngredientCategory $category;
    
    /** VARCHAR(255) NULL */
    private ?string $description = null;
    
    /** DECIMAL(10,2) NOT NULL */
    private float $price_per_100g;
    
    /** DECIMAL(10,2) NOT NULL */
    private float $kcal_per_100g;
    
    /** TINYINT(1) NOT NULL DEFAULT 0 */
    private bool $has_doneness;
    
    /** VARCHAR(120) NOT NULL */
    private string $country;
    
    /** TINYINT(1) NOT NULL DEFAULT 1 */
    private bool $available;
    
    /** DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP */
    private string $created_at;
    
    /** DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE */
    private string $updated_at;

    /** @var IngredientMacronutrient[]|null */
    private ?array $macronutrients = null;
    
    /** @var IngredientAllergen[]|null */
    private ?array $allergens = null;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_ingredient = (int)($data['id_ingredient'] ?? 0);
            $this->name = (string)($data['name'] ?? '');
            $this->category = isset($data['category']) ? IngredientCategory::from($data['category']) : IngredientCategory::UNDEFINED;
            $this->description = isset($data['description']) ? (string)$data['description'] : null;
            $this->price_per_100g = (float)($data['price_per_100g'] ?? 0.0);
            $this->kcal_per_100g = (float)($data['kcal_per_100g'] ?? 0.0);
            $this->has_doneness = (bool)($data['has_doneness'] ?? false);
            $this->country = (string)($data['country'] ?? '');
            $this->available = (bool)($data['available'] ?? $data['avaliable'] ?? true);
            $this->created_at = (string)($data['created_at'] ?? date('Y-m-d H:i:s'));
            $this->updated_at = (string)($data['updated_at'] ?? date('Y-m-d H:i:s'));
            if (isset($data['macronutrients']) && is_array($data['macronutrients'])) {
                $this->setMacronutrients($data['macronutrients']);
            } else {
                $this->macronutrients = $data['macronutrients'] ?? null;
            }

            if (isset($data['allergens']) && is_array($data['allergens'])) {
                $this->setAllergens($data['allergens']);
            } else {
                $this->allergens = $data['allergens'] ?? null;
            }
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

    public function getCategory(): IngredientCategory
    {
        return $this->category;
    }
    public function setCategory(IngredientCategory|string $category)
    {
        $this->category = is_string($category) ? IngredientCategory::from($category) : $category;
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

    /**
     * Get macronutrient association objects for this ingredient
     * @return IngredientMacronutrient[]|null
     */
    public function getMacronutrients(): ?array
    {
        return $this->macronutrients;
    }
    /**
     * Set macronutrient association objects for this ingredient
     * @param IngredientMacronutrient[]|null $macros
     */
    public function setMacronutrients(?array $macros)
    {
        if ($macros === null) {
            $this->macronutrients = null;
            return $this;
        }

        $this->macronutrients = [];
        foreach ($macros as $m) {
            if ($m instanceof IngredientMacronutrient) {
                $this->macronutrients[] = $m;
                continue;
            }

            if (is_array($m)) {
                $this->macronutrients[] = new IngredientMacronutrient($m);
                continue;
            }

            if (is_object($m)) {
                $this->macronutrients[] = new IngredientMacronutrient((array)$m);
                continue;
            }
        }

        return $this;
    }

    /**
     * Get allergen association objects for this ingredient
     * @return IngredientAllergen[]|null
     */
    public function getAllergens(): ?array
    {
        return $this->allergens;
    }
    /**
     * Set allergen association objects for this ingredient
     * @param IngredientAllergen[]|null $allergens
     */
    public function setAllergens(?array $allergens)
    {
        if ($allergens === null) {
            $this->allergens = null;
            return $this;
        }

        $this->allergens = [];
        foreach ($allergens as $a) {
            if ($a instanceof IngredientAllergen) {
                $this->allergens[] = $a;
                continue;
            }

            if (is_array($a)) {
                $this->allergens[] = new IngredientAllergen($a);
                continue;
            }

            if (is_object($a)) {
                $this->allergens[] = new IngredientAllergen((array)$a);
                continue;
            }
        }

        return $this;
    }
}