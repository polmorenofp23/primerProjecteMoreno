<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'Ingredient.php';
require_once DAO_PATH . 'IngredientMacronutrientDAO.php';
require_once DAO_PATH . 'AllergenDAO.php';

use IngredientCategory;

class IngredientDAO{

    private $db;
    private $conn;

    public function __construct(){
        $this->db = new DatabasePDO();
    }

    /**
     * It returns all ingredients from the database
     */
    public function getAllIngredients()
    {
        return $this->getIngredientsByFilter();
    }

    /**
     * General filtering function for ingredients.
     * Supported filters keys:
     *  - id: int or array of ints
     *  - contains_allergen: int or array of ints
     *  - without_allergen: int or array of ints
     *  - name: string (partial match)
     *  - category: string or array of strings
     *  - available: bool
     * $orderBy: 'price_asc', 'price_desc', 'category'
     */
    public function getIngredientsByFilter(array $filters = [], ?string $orderBy = null)
    {
        $this->conn = $this->db->connect();

        $params = [];
        $wheres = [];
        $joins = '';

        $select = 'SELECT i.* FROM ingredient i';

        // by id
        if (isset($filters['id'])) {
            if (is_array($filters['id'])) {
                $placeholders = [];
                foreach ($filters['id'] as $i => $v) {
                    $ph = ':id_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = (int)$v;
                }
                $wheres[] = 'i.id_ingredient IN (' . implode(',', $placeholders) . ')';
            } else {
                $wheres[] = 'i.id_ingredient = :id';
                $params[':id'] = (int)$filters['id'];
            }
        }

        // by contains_allergen
        if (isset($filters['contains_allergen'])) {
            $vals = is_array($filters['contains_allergen']) ? $filters['contains_allergen'] : [$filters['contains_allergen']];
            $placeholders = [];
            foreach ($vals as $i => $v) {
                $ph = ':contains_allergen_' . $i;
                $placeholders[] = $ph;
                $params[$ph] = (int)$v;
            }
            $in = implode(',', $placeholders);
            $wheres[] = "i.id_ingredient IN (SELECT id_ingredient FROM ingredient_allergen WHERE id_allergen IN ($in))";
        }

        // by without_allergen
        if (isset($filters['without_allergen'])) {
            $vals = is_array($filters['without_allergen']) ? $filters['without_allergen'] : [$filters['without_allergen']];
            $placeholders = [];
            foreach ($vals as $i => $v) {
                $ph = ':without_allergen_' . $i;
                $placeholders[] = $ph;
                $params[$ph] = (int)$v;
            }
            $in = implode(',', $placeholders);
            $wheres[] = "i.id_ingredient NOT IN (SELECT id_ingredient FROM ingredient_allergen WHERE id_allergen IN ($in))";
        }

        // by name (inclusive partial match)
        if (isset($filters['name']) && $filters['name'] !== '') {
            $wheres[] = 'i.name LIKE :name';
            $params[':name'] = '%' . $filters['name'] . '%';
        }

        // by category (accept string or array)
        if (isset($filters['category'])) {
            $vals = is_array($filters['category']) ? $filters['category'] : [$filters['category']];
            $placeholders = [];
            foreach ($vals as $i => $v) {
                // accept IngredientCategory or string
                $val = is_string($v) ? $v : $v->value;
                $ph = ':category_' . $i;
                $placeholders[] = $ph;
                $params[$ph] = $val;
            }
            $wheres[] = 'i.category IN (' . implode(',', $placeholders) . ')';
        }

        // by available
        if (isset($filters['available'])) {
            $wheres[] = 'i.available = :available';
            $params[':available'] = (bool)$filters['available'];
        }

        // mounting the final query
        $sql = $select;
        if ($joins) $sql .= ' ' . $joins;
        if (!empty($wheres)) $sql .= ' WHERE ' . implode(' AND ', $wheres);

        // ordering the query content
        $orderByQuery = '';
        if ($orderBy) {
            switch ($orderBy) {
                case 'price_asc':
                    $orderByQuery = ' ORDER BY i.price_per_100g ASC';
                    break;
                case 'price_desc':
                    $orderByQuery = ' ORDER BY i.price_per_100g DESC';
                    break;
                case 'category':
                    $orderByQuery = ' ORDER BY i.category ASC';
                    break;
                default:
                    break;
            }
        }

        $sql .= $orderByQuery;
        
         // bind all params
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $k => $v) {
            if (is_int($v)) $stmt->bindValue($k, $v, PDO::PARAM_INT);
            elseif (is_bool($v)) $stmt->bindValue($k, $v, PDO::PARAM_BOOL);
            else $stmt->bindValue($k, $v, PDO::PARAM_STR);
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->db->disconnect();

        $ingredientsList = [];
        $imDao = new IngredientMacronutrientDAO();
        $allDao = new AllergenDAO();
        foreach ($results as $row) {
            $ingredient = new Ingredient($row);
            $macros = $imDao->getMacronutrientsByIngredient((int)$ingredient->getId());
            $ingredient->setMacronutrients($macros);
            $allergens = $allDao->getAllergensByIngredient((int)$ingredient->getId());
            $ingredient->setAllergens($allergens);
            $ingredientsList[] = $ingredient;
        }

        return $ingredientsList;
    }
}
