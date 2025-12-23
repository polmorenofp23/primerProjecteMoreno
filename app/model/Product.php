<?php

class Product
{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private int $id_product;
    
    /** VARCHAR(120) NOT NULL */
    private string $name;
    
    /** TEXT NULL */
    private ?string $description = null;
    
    /** ENUM('appetiser','main','dessert','drink') NOT NULL */
    private string $dish_type;
    
    /** DECIMAL(10,2) NOT NULL DEFAULT 0.00 - price in DB */
    private float $price;
    
    /** JSON NOT NULL - can be string (JSON) or array (decoded) */
    private array $img_dir;
    
    /** TINYINT(1) NOT NULL DEFAULT 1 - available in DB */
    private bool $available;
    
    /** DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP */
    private string $created_at;
    
    /** DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE */
    private string $updated_at;
    
    /** Array of ProductIngredient objects */
    private array $ingredients = [];

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_product = (int)($data['id_product'] ?? 0);
            $this->name = (string)($data['name'] ?? '');
            $this->description = isset($data['description']) ? (string)$data['description'] : null;
            $this->dish_type = (string)($data['dish_type'] ?? '');
            $this->price = (float)($data['price'] ?? 0.0);
            $this->img_dir = isset($data['img_dir']) ? (is_string($data['img_dir']) ? json_decode($data['img_dir'], true) : $data['img_dir']) : [];
            $this->available = (bool)($data['available'] ?? true);
            $this->created_at = (string)($data['created_at'] ?? date('Y-m-d H:i:s'));
            $this->updated_at = (string)($data['updated_at'] ?? date('Y-m-d H:i:s'));
            
            if (isset($data['ingredients']) && is_array($data['ingredients'])) {
                $this->setIngredients($data['ingredients']);
            }
        }
    }

    public function getId()
    {
        return $this->id_product;
    }
    public function setId($id)
    {
        $this->id_product = $id;

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

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDishType()
    {
        return $this->dish_type;
    }
    public function setDishType($dish_type)
    {
        $this->dish_type = $dish_type;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getImgDir()
    {
        return $this->img_dir;
    }
    public function setImgDir($img_dir)
    {
        $this->img_dir = $img_dir;

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

    function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Ingredients associated with the product
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients)
    {
        $this->ingredients = [];
        foreach ($ingredients as $ingredient) {
            if ($ingredient instanceof ProductIngredient) {
                $this->ingredients[] = $ingredient;
                continue;
            }

            if (is_array($ingredient)) {
                $this->ingredients[] = new ProductIngredient($ingredient);
                continue;
            }

            if (is_object($ingredient)) {
                $this->ingredients[] = new ProductIngredient((array)$ingredient);
                continue;
            }

        }

        return $this;
    }

    public function addIngredient($ingredient)
    {
        if (!($ingredient instanceof ProductIngredient)) {
            if (is_array($ingredient) || is_object($ingredient)) {
                $ingredient = new ProductIngredient((array)$ingredient);
            } else {
                return $this;   // invalid ingredient type, ignore
            }
        }

        $this->ingredients[] = $ingredient;
        return $this;
    }

    /**
     * Remove an ingredient from the list by ingredient id. No-op if not found.
     *
     * @param int|string $ingredientId Ingredient identifier (numeric)
     * @return self
     */
    public function removeIngredient($ingredientId)
    {
        if (!(is_int($ingredientId) || (is_string($ingredientId) && ctype_digit($ingredientId)))) {
            return $this;
        }
        $targetId = (int)$ingredientId;

        foreach ($this->ingredients as $k => $item) {
            $id = null;
            if ($item instanceof ProductIngredient && method_exists($item, 'getIngredientId')) {
                $id = (int)$item->getIngredientId();
            } elseif (is_array($item)) {
                if (isset($item['ingredient_id'])) $id = (int)$item['ingredient_id'];
                elseif (isset($item['id_ingredient'])) $id = (int)$item['id_ingredient'];
            } elseif (is_object($item) && method_exists($item, 'getId')) {
                $id = (int)$item->getId();
            }

            if ($id !== null && $id === $targetId) {
                unset($this->ingredients[$k]);
                $this->ingredients = array_values($this->ingredients);
                break;
            }
        }
        return $this;
    }

    /**
     * Get ingredients that are default (is_default = true).
     * @return array<ProductIngredient|array>
     */
    public function getDefaultIngredients(): array
    {
        $out = [];
        foreach ($this->ingredients as $ing) {
            if ($ing instanceof ProductIngredient) {
                if (method_exists($ing, 'getIsDefault') && $ing->getIsDefault()) {
                    $out[] = $ing;
                }
            } elseif (is_array($ing)) {
                if (!empty($ing['is_default'])) {
                    $out[] = $ing;
                }
            }
        }
        return $out;
    }

    /**
     * Get ingredients that are extras (is_default = false).
     * @return array<ProductIngredient|array>
     */
    public function getExtraIngredients(): array
    {
        $out = [];
        foreach ($this->ingredients as $ing) {
            if ($ing instanceof ProductIngredient) {
                if (method_exists($ing, 'getIsDefault') && !$ing->getIsDefault()) {
                    $out[] = $ing;
                }
            } elseif (is_array($ing)) {
                if (array_key_exists('is_default', $ing) && !$ing['is_default']) {
                    $out[] = $ing;
                }
            }
        }
        return $out;
    }

    /**
     * Get the final selected ingredients (is_in_final_product = true).
     * Falls back to is_default when the runtime flag is not present.
     * @return array<ProductIngredient|array>
     */
    public function getFinalIngredients(): array
    {
        $out = [];
        foreach ($this->ingredients as $ing) {
            if ($ing instanceof ProductIngredient) {
                if (method_exists($ing, 'getIsInFinalProduct')) {
                    if ($ing->getIsInFinalProduct()) $out[] = $ing;
                } else {
                    if (method_exists($ing, 'getIsDefault') && $ing->getIsDefault()) $out[] = $ing;
                }
            } elseif (is_array($ing)) {
                $flag = $ing['is_in_final_product'] ?? $ing['isInFinalProduct'] ?? ($ing['is_default'] ?? false);
                if ($flag) $out[] = $ing;
            }
        }
        return $out;
    }

    /**
     * Reset runtime selection so each ingredient matches its is_default value.
     * @return self
     */
    public function resetFinalSelection(): self
    {
        foreach ($this->ingredients as $ing) {
            if ($ing instanceof ProductIngredient) {
                if (method_exists($ing, 'setIsInFinalProduct')) {
                    $base = method_exists($ing, 'getIsDefault') ? $ing->getIsDefault() : false;
                    $ing->setIsInFinalProduct($base);
                }
            } elseif (is_array($ing)) {
                $base = $ing['is_default'] ?? false;
                $ing['is_in_final_product'] = $base;
            }
        }
        return $this;
    }

    /**
     * Set the runtime final selection flag for a specific ingredient id.
     * @param int|string $ingredientId
     * @param bool $inFinal
     * @return self
     */
    public function setIngredientFinalState($ingredientId, bool $inFinal): self
    {
        foreach ($this->ingredients as $idx => $ing) {
            if ($ing instanceof ProductIngredient) {
                $id = method_exists($ing, 'getIngredientId') ? $ing->getIngredientId() : null;
                if ($id !== null && (int)$id === (int)$ingredientId) {
                    if (method_exists($ing, 'setIsInFinalProduct')) {
                        $ing->setIsInFinalProduct($inFinal);
                    }
                    break;
                }
            } elseif (is_array($ing)) {
                $id = $ing['ingredient_id'] ?? $ing['id_ingredient'] ?? null;
                if ($id !== null && (int)$id === (int)$ingredientId) {
                    $this->ingredients[$idx]['is_in_final_product'] = $inFinal;
                    break;
                }
            }
        }
        return $this;
    }
}