<?php

require_once DAO_PATH . 'IngredientDAO.php';
require_once UTIL_PATH . 'JsonUtils.php';

class APIIngredientController
{
    /**
     * List ingredients (optional filters: category, available, contains_allergen, without_allergen, name, ids)
     * Responds with JSON: { status, data: Ingredient[] }
     */
    // GET /?controller=api&resource=Ingredient
    public function index()
    {
        $iDao = new IngredientDAO();
        $filters = [];

        if (isset($_GET['category']) && $_GET['category'] !== '') {
            $val = trim($_GET['category']);
            if (strpos($val, ',') !== false) {
                $filters['category'] = array_map('trim', explode(',', $val));
            } else {
                $filters['category'] = $val;
            }
        }

        if (isset($_GET['available'])) {
            $filters['available'] = (bool)intval($_GET['available']);
        }

        if (isset($_GET['contains_allergen']) && $_GET['contains_allergen'] !== '') {
            $val = trim($_GET['contains_allergen']);
            if (strpos($val, ',') !== false) {
                $filters['contains_allergen'] = array_map('intval', array_map('trim', explode(',', $val)));
            } else {
                $filters['contains_allergen'] = (int)$val;
            }
        }

        if (isset($_GET['without_allergen']) && $_GET['without_allergen'] !== '') {
            $val = trim($_GET['without_allergen']);
            if (strpos($val, ',') !== false) {
                $filters['without_allergen'] = array_map('intval', array_map('trim', explode(',', $val)));
            } else {
                $filters['without_allergen'] = (int)$val;
            }
        }

        if (isset($_GET['name']) && $_GET['name'] !== '') {
            $filters['name'] = trim($_GET['name']);
        }

        if (isset($_GET['ids']) && $_GET['ids'] !== '') {
            $filters['id'] = array_map('intval', array_map('trim', explode(',', $_GET['ids'])));
        }

        $orderBy = $_GET['order_by'] ?? null;

        $ingredients = $iDao->getIngredientsByFilter($filters, $orderBy);

        JsonUtils::jsonResponse(JsonUtils::serializeArray($ingredients, 'serializeIngredient', $this));
    }

    // ---------- Helpers ----------

    public function serializeIngredient($ingredient)
    {
        if (!$ingredient) return null;
        return [
            'id' => $ingredient->getId(),
            'name' => $ingredient->getName(),
            'category' => $ingredient->getCategory(),
            'description' => $ingredient->getDescription(),
            'pricePer100g' => $ingredient->getPricePer100g(),
            'kcalPer100g' => $ingredient->getKcalPer100g(),
            'hasDoneness' => $ingredient->getHasDoneness(),
            'country' => $ingredient->getCountry(),
            'available' => $ingredient->getAvailable(),
            'createdAt' => $ingredient->getCreatedAt(),
            'updatedAt' => $ingredient->getUpdatedAt(),
            'macronutrients' => $this->serializeIngredientMacronutrient($ingredient->getMacronutrients()),
            'allergens' => $this->serializeAllergens($ingredient->getAllergens()),
        ];
    }

    private function serializeIngredientMacronutrient($macros)
    {
        if (!is_array($macros)) return [];
        return JsonUtils::serializeArray($macros, function($m) {
            return [
                'ingredientId' => method_exists($m, 'getIngredientId') ? $m->getIngredientId() : null,
                'macronutrientId' => method_exists($m, 'getMacronutrientId') ? $m->getMacronutrientId() : null,
                'gramsPer100g' => method_exists($m, 'getGramsPer100g') ? $m->getGramsPer100g() : null,
            ];
        });
    }

    private function serializeAllergens($allergens)
    {
        if (!is_array($allergens)) return [];
        return JsonUtils::serializeArray($allergens, function($a) {
            return [
                'id' => method_exists($a, 'getId') ? $a->getId() : null,
                'name' => method_exists($a, 'getName') ? $a->getName() : null,
                'description' => method_exists($a, 'getDescription') ? $a->getDescription() : null,
                'iconDir' => method_exists($a, 'getIconDir') ? $a->getIconDir() : null,
            ];
        });
    }
}
