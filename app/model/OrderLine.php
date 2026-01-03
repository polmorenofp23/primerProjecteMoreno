<?php

class OrderLine
{
    /** BIGINT UNSIGNED - PK AUTO_INCREMENT */
    private int $id_line;
    
    /** BIGINT UNSIGNED NOT NULL */
    private int $id_order;
    
    /** BIGINT UNSIGNED NOT NULL */
    private int $id_product;
    
    /** INT UNSIGNED NOT NULL */
    private int $quantity;
    
    /** DECIMAL(10,2) NOT NULL */
    private float $unit_price;

    /** Array of OrderLineIngredient objects */
    private array $ingredients = [];

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_line = (int)($data['id_line'] ?? $data['id'] ?? 0);
            $this->id_order = (int)($data['id_order'] ?? 0);
            $this->id_product = (int)($data['id_product'] ?? 0);
            $this->quantity = (int)($data['quantity'] ?? 0);
            $this->unit_price = (float)($data['unit_price'] ?? 0.0);
            
            if (isset($data['ingredients']) && is_array($data['ingredients'])) {
                $this->setIngredients($data['ingredients']);
            }
        }
    }

    public function getId()
    {
        return $this->id_line;
    }

    public function setId($id)
    {
        $this->id_line = $id;
        return $this;
    }

    public function getOrderId()
    {
        return $this->id_order;
    }
    public function setOrderId($id)
    {
        $this->id_order = $id;
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

    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($q)
    {
        $this->quantity = $q;
        return $this;
    }

    public function getUnitPrice()
    {
        return $this->unit_price;
    }
    public function setUnitPrice($p)
    {
        $this->unit_price = $p;
        return $this;
    }

    /**
     * Ingredients associated with the order line
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients)
    {
        $this->ingredients = [];
        foreach ($ingredients as $ingredient) {
            if ($ingredient instanceof OrderLineIngredient) {
                $this->ingredients[] = $ingredient;
                continue;
            }

            if (is_array($ingredient)) {
                $this->ingredients[] = new OrderLineIngredient($ingredient);
                continue;
            }

            if (is_object($ingredient)) {
                $this->ingredients[] = new OrderLineIngredient((array)$ingredient);
                continue;
            }
        }

        return $this;
    }

    public function addIngredient($ingredient)
    {
        if (!($ingredient instanceof OrderLineIngredient)) {
            if (is_array($ingredient) || is_object($ingredient)) {
                $ingredient = new OrderLineIngredient((array)$ingredient);
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
            if ($item instanceof OrderLineIngredient && method_exists($item, 'getIngredientId')) {
                $id = (int)$item->getIngredientId();
            } elseif (is_array($item)) {
                if (isset($item['id_ingredient'])) $id = (int)$item['id_ingredient'];
                elseif (isset($item['ingredient_id'])) $id = (int)$item['ingredient_id'];
            } elseif (is_object($item) && method_exists($item, 'getIngredientId')) {
                $id = (int)$item->getIngredientId();
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
     * Get ingredients that are default (origin = 'default').
     * @return array<OrderLineIngredient|array>
     */
    public function getDefaultIngredients(): array
    {
        $out = [];
        foreach ($this->ingredients as $ing) {
            if ($ing instanceof OrderLineIngredient) {
                if (method_exists($ing, 'getOrigin') && $ing->getOrigin() === 'default') {
                    $out[] = $ing;
                }
            } elseif (is_array($ing)) {
                if (isset($ing['origin']) && $ing['origin'] === 'default') {
                    $out[] = $ing;
                }
            }
        }
        return $out;
    }

    /**
     * Get ingredients that are extras (origin = 'extra').
     * @return array<OrderLineIngredient|array>
     */
    public function getExtraIngredients(): array
    {
        $out = [];
        foreach ($this->ingredients as $ing) {
            if ($ing instanceof OrderLineIngredient) {
                if (method_exists($ing, 'getOrigin') && $ing->getOrigin() === 'extra') {
                    $out[] = $ing;
                }
            } elseif (is_array($ing)) {
                if (isset($ing['origin']) && $ing['origin'] === 'extra') {
                    $out[] = $ing;
                }
            }
        }
        return $out;
    }

    /**
     * Calculate total price for ingredients based on ingredient_price field.
     * @return float
     */
    public function calculateUnitPriceByIngredientsPrice(): float
    {
        $total = 0.0;
        foreach ($this->ingredients as $ing) {
            if ($ing instanceof OrderLineIngredient) {
                if (method_exists($ing, 'getIngredientPrice')) {
                    $total += $ing->getIngredientPrice();
                }
            } elseif (is_array($ing)) {
                $total += (float)($ing['ingredient_price'] ?? 0.0);
            }
        }
        return $total;
    }
}