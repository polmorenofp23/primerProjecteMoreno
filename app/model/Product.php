<?php

class Product
{
    private $id_product;
    private $name;
    private $description;
    private $dish_type;
    private $price;
    private $img_dir;
    private $avaliable;
    private $created_at;
    private $updated_at;
    private $ingredients = []; // array of ProductIngredient

    public function __construct($data = null)
    {
        if ($data) {
            $this->id_product = $data['id_product'] ?? $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->dish_type = $data['dish_type'] ?? $data['dishType'] ?? null;
            $this->price = $data['price'] ?? $data['price'] ?? null;
            $this->img_dir = $data['img_dir'] ?? $data['imgDir'] ?? null;
            $this->avaliable = $data['avaliable'] ?? $data['available'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
            // initialize ingredients as ProductIngredient objects when provided
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

    public function getAvaliable()
    {
        return $this->avaliable;
    }
    public function setAvaliable($avaliable)
    {
        $this->avaliable = $avaliable;

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
                // cast object to array to feed constructor
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
                // invalid ingredient type, ignore
                return $this;
            }
        }

        $this->ingredients[] = $ingredient;
        return $this;
    }

    /**
     * ------------------------ REVUISAR BE LA LLOGICA -------------------------------
     * Remove an ingredient from the product's ingredients collection (in-memory).
     * Accepts an ingredient id or a ProductIngredient/Ingredient instance.
     */
    public function removeIngredient($ingredientIdentifier)
    {
        /*
         * Objetivo: eliminar de $this->ingredients el ingrediente identificado por
         * $ingredientIdentifier. Se acepta como entrada:
         * - un id (int o string numérico),
         * - un objeto (ProductIngredient o Ingredient) con métodos getIngredientId()/getId(),
         * - un array con estructura proveniente de un JOIN (p.ej. ['productIngredient'=>..., 'ingredient'=>...]).
         *
         * Estrategia:
         * 1) Normalizar/extraer un identificador entero ($targetId) desde la entrada.
         * 2) Recorrer $this->ingredients (que idealmente contiene ProductIngredient instances)
         *    y comparar su id con $targetId.
         * 3) Si hay coincidencia, eliminar el elemento y reindexar el array.
         */

        // 1) Extraer id objetivo de la entrada
        $targetId = null;

        // Si nos pasan un número o string numérico, lo tomamos como id directo
        if (is_int($ingredientIdentifier) || (is_string($ingredientIdentifier) && ctype_digit($ingredientIdentifier))) {
            $targetId = (int)$ingredientIdentifier;
        } elseif (is_object($ingredientIdentifier)) {
            // Si nos pasan un objeto, intentamos obtener su id mediante métodos conocidos
            if (method_exists($ingredientIdentifier, 'getIngredientId')) {
                $targetId = $ingredientIdentifier->getIngredientId();
            } elseif (method_exists($ingredientIdentifier, 'getId')) {
                $targetId = $ingredientIdentifier->getId();
            } elseif (property_exists($ingredientIdentifier, 'id_ingredient')) {
                // fallback si es un stdClass con propiedad pública
                $targetId = (int)$ingredientIdentifier->id_ingredient;
            }
        } elseif (is_array($ingredientIdentifier)) {
            // Si nos pasan un array (por ejemplo fila de JOIN), buscar claves comunes
            if (isset($ingredientIdentifier['ingredient']['id_ingredient'])) {
                $targetId = (int)$ingredientIdentifier['ingredient']['id_ingredient'];
            } elseif (isset($ingredientIdentifier['ingredient']['id'])) {
                $targetId = (int)$ingredientIdentifier['ingredient']['id'];
            } elseif (isset($ingredientIdentifier['productIngredient']['ingredient_id'])) {
                $targetId = (int)$ingredientIdentifier['productIngredient']['ingredient_id'];
            } elseif (isset($ingredientIdentifier['productIngredient']['ingredientId'])) {
                $targetId = (int)$ingredientIdentifier['productIngredient']['ingredientId'];
            } elseif (isset($ingredientIdentifier['id_ingredient'])) {
                $targetId = (int)$ingredientIdentifier['id_ingredient'];
            }
        }

        // Si no pudimos extraer id, no hay nada que hacer
        if ($targetId === null) {
            return $this;
        }

        // 2) Recorrer la colección y comparar
        foreach ($this->ingredients as $k => $item) {
            // Caso ideal: cada item es instancia de ProductIngredient (normalizado por setIngredients/addIngredient)
            if ($item instanceof ProductIngredient) {
                // Intentamos obtener el id desde métodos de la clase ProductIngredient
                $id = null;
                if (method_exists($item, 'getIngredientId')) {
                    $id = $item->getIngredientId();
                } elseif (method_exists($item, 'getId')) {
                    $id = $item->getId();
                }

                if ($id !== null && (int)$id === $targetId) {
                    unset($this->ingredients[$k]);
                    // 3) Reindexar para mantener array numerado limpio
                    $this->ingredients = array_values($this->ingredients);
                    return $this;
                }

                // si no coincide con este item, seguir al siguiente
                continue;
            }

            // Si el elemento es un array (p. ej. estructura JOIN) comprobamos claves internas
            if (is_array($item)) {
                // chequeo 'productIngredient' primero
                if (isset($item['productIngredient'])) {
                    $pi = $item['productIngredient'];
                    if (is_object($pi) && method_exists($pi, 'getIngredientId') && $pi->getIngredientId() == $targetId) {
                        unset($this->ingredients[$k]);
                        $this->ingredients = array_values($this->ingredients);
                        return $this;
                    }
                    if (is_array($pi) && (isset($pi['ingredient_id']) || isset($pi['ingredientId']) || isset($pi['id_ingredient']))) {
                        $pid = $pi['ingredient_id'] ?? $pi['ingredientId'] ?? $pi['id_ingredient'];
                        if ((int)$pid === $targetId) {
                            unset($this->ingredients[$k]);
                            $this->ingredients = array_values($this->ingredients);
                            return $this;
                        }
                    }
                }

                // chequeo 'ingredient' si existe
                if (isset($item['ingredient'])) {
                    $ing = $item['ingredient'];
                    if (is_object($ing) && method_exists($ing, 'getId') && $ing->getId() == $targetId) {
                        unset($this->ingredients[$k]);
                        $this->ingredients = array_values($this->ingredients);
                        return $this;
                    }
                    if (is_array($ing) && (isset($ing['id_ingredient']) || isset($ing['id']))) {
                        $iid = $ing['id_ingredient'] ?? $ing['id'];
                        if ((int)$iid === $targetId) {
                            unset($this->ingredients[$k]);
                            $this->ingredients = array_values($this->ingredients);
                            return $this;
                        }
                    }
                }

                // si no coincidió, seguir
                continue;
            }

            // Si el elemento es un objeto genérico (no ProductIngredient), intentamos métodos comunes
            if (is_object($item)) {
                if (method_exists($item, 'getIngredientId') && $item->getIngredientId() == $targetId) {
                    unset($this->ingredients[$k]);
                    $this->ingredients = array_values($this->ingredients);
                    return $this;
                }
                if (method_exists($item, 'getId') && $item->getId() == $targetId) {
                    unset($this->ingredients[$k]);
                    $this->ingredients = array_values($this->ingredients);
                    return $this;
                }
            }
        }

        // si no se encontró coincidencia, devolvemos el producto sin cambios
        return $this;
    }
}