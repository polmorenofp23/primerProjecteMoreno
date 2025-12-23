<?php

require_once UTIL_PATH . 'DatabasePDO.php';
require_once MODEL_PATH . 'Product.php';
require_once DAO_PATH . 'ProductIngredientDAO.php';

class ProductDAO{

    private $db;
    private $conn;

    public function __construct(){
        $this->db = new DatabasePDO();
    }

    /**
     * It returns all products from the database
     */
    public function getAllProducts()
    {
        return $this->getProductsByFilter();
    }

    /**
     * General filtering function for products.
     * Supported filters keys:
     *  - id: int
     *  - contains_allergen: int (allergen id) -> products that contain that allergen
     *  - without_allergen: int (allergen id) -> products that do NOT contain that allergen
     *  - dish_type: string
     *  - price_range: [min, max]
     *  - ingredient_category: string
     *  - available: bool
     * $orderBy: can be 'price_asc', 'price_desc', 'dish_type', 'name'
     */
    public function getProductsByFilter(array $filters = [], ?string $orderBy = null)
    {
        $this->conn = $this->db->connect();

        $params = [];
        $joins = '';
        $wheres = [];
        $select = 'SELECT DISTINCT p.* FROM product p';

        // by specific id (accepts single id or array of ids)
        if (isset($filters['id'])) {
            if (is_array($filters['id'])) {
                $vals = $filters['id'];
                $placeholders = [];
                foreach ($vals as $i => $val) {
                    $ph = ':id_product_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = (int)$val;
                }
                $in = implode(',', $placeholders);
                $wheres[] = "p.id_product IN ($in)";
            } else {
                $wheres[] = 'p.id_product = :id_product';
                $params[':id_product'] = (int)$filters['id'];
            }
        }

        // by contains_allergen
        if (isset($filters['contains_allergen'])) {
            $vals = is_array($filters['contains_allergen']) ? $filters['contains_allergen'] : [$filters['contains_allergen']];
            $placeholders = [];
            foreach ($vals as $i => $val) {
                $ph = ':contains_allergen_' . $i;
                $placeholders[] = $ph;
                $params[$ph] = (int)$val;
            }
            $in = implode(',', $placeholders);
            $wheres[] = "p.id_product IN (
                SELECT DISTINCT pi.id_product
                FROM product_ingredient pi
                JOIN ingredient_allergen ia ON ia.id_ingredient = pi.id_ingredient
                WHERE ia.id_allergen IN ($in)
            )";
        }

        // by without_allergen
        if (isset($filters['without_allergen'])) {
            $vals = is_array($filters['without_allergen']) ? $filters['without_allergen'] : [$filters['without_allergen']];
            $placeholders = [];
            foreach ($vals as $i => $val) {
                $ph = ':without_allergen_' . $i;
                $placeholders[] = $ph;
                $params[$ph] = (int)$val;
            }
            $in = implode(',', $placeholders);
            $wheres[] = "p.id_product NOT IN (
                SELECT DISTINCT pi.id_product
                FROM product_ingredient pi
                JOIN ingredient_allergen ia ON ia.id_ingredient = pi.id_ingredient
                WHERE ia.id_allergen IN ($in)
            )";
        }

        // by ingredient category (accept string or array)
        if (isset($filters['ingredient_category'])) {
            $vals = is_array($filters['ingredient_category']) ? $filters['ingredient_category'] : [$filters['ingredient_category']];
            $placeholders = [];
            foreach ($vals as $i => $val) {
                $ph = ':ingredient_category_' . $i;
                $placeholders[] = $ph;
                $params[$ph] = $val;
            }
            $in = implode(',', $placeholders);
            $wheres[] = "p.id_product IN (
                SELECT DISTINCT pi.id_product
                FROM product_ingredient pi
                JOIN ingredient i ON i.id_ingredient = pi.id_ingredient
                WHERE i.category IN ($in)
            )";
        }

        // by name like (search by partial name)
        if (isset($filters['name_like']) && $filters['name_like'] !== '') {
            $wheres[] = 'p.name LIKE :name_like';
            $params[':name_like'] = '%' . $filters['name_like'] . '%';
        }

        // by dish_type (accept string or array)
        if (isset($filters['dish_type'])) {
            if (is_array($filters['dish_type'])) {
                $vals = $filters['dish_type'];
                $placeholders = [];
                foreach ($vals as $i => $val) {
                    $ph = ':dish_type_' . $i;
                    $placeholders[] = $ph;
                    $params[$ph] = $val;
                }
                $in = implode(',', $placeholders);
                $wheres[] = "p.dish_type IN ($in)";
            } else {
                $wheres[] = 'p.dish_type = :dish_type';
                $params[':dish_type'] = $filters['dish_type'];
            }
        }

        // by price range
        if (isset($filters['price_range']) && is_array($filters['price_range'])) {
            $min = $filters['price_range'][0];
            $max = $filters['price_range'][1];
            $wheres[] = 'p.price BETWEEN :min_price AND :max_price';
            $params[':min_price'] = $min;
            $params[':max_price'] = $max;
        }

        // by availability
        if (isset($filters['available'])) {
            $wheres[] = 'p.available = :available';
            $params[':available'] = (bool)$filters['available'];
        }

        // mount the SQL query
        $sql = $select;
        if ($joins) $sql .= ' ' . $joins;
        if (!empty($wheres)) {
            $sql .= ' WHERE ' . implode(' AND ', $wheres);
        }

        // ordering the query content
        $orderByQuery = '';
        if ($orderBy) {
            switch ($orderBy) {
                case 'price_asc':
                    $orderByQuery = ' ORDER BY p.price ASC';
                    break;
                case 'price_desc':
                    $orderByQuery = ' ORDER BY p.price DESC';
                    break;
                case 'dish_type':
                    $orderByQuery = ' ORDER BY p.dish_type ASC';
                    break;
                case 'name':
                    $orderByQuery = ' ORDER BY p.name ASC';
                    break;
                default:
                    break;
            }
        }

        $sql .= $orderByQuery;

        // bind all params
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $k => $v) {
            if (is_int($v)) {
                $stmt->bindValue($k, $v, PDO::PARAM_INT);
            } elseif (is_bool($v)) {
                $stmt->bindValue($k, $v, PDO::PARAM_BOOL);
            } elseif (is_float($v)) {
                $stmt->bindValue($k, (string)$v);   // bind as string becose PDO has no native float param type
            } else {
                $stmt->bindValue($k, $v, PDO::PARAM_STR);
            }
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $productsList = [];
        $piDao = new ProductIngredientDAO();
        foreach ($results as $result) {
            $product = new Product($result);
            $ingredients = $piDao->getIngredientsByProduct((int)$product->getId()); // Load and assign ProductIngredient list into the Product model
            $product->setIngredients($ingredients);
            $productsList[] = $product;
        }

        $this->db->disconnect();

        return $productsList;
    }

    // ----------------- CREATE METHODS -----------------
    /**
     * Create a new product in the database
     * Returns the id of the created product, or false on failure
     */
    public function createProduct(Product $product)
    {
        $this->conn = $this->db->connect();

        $query = "INSERT INTO product (name, description, dish_type, price, img_dir, available) 
                VALUES (:name, :description, :dish_type, :price, :img_dir, :available)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':name', $product->getName());
        $stmt->bindValue(':description', $product->getDescription() ?? '');
        $stmt->bindValue(':dish_type', $product->getDishType());
        $stmt->bindValue(':price', $product->getPrice());
        $stmt->bindValue(':img_dir', json_encode($product->getImgDir()));
        $stmt->bindValue(':available', (bool)$product->getAvailable(), PDO::PARAM_BOOL);
        $stmt->execute();

        $id = $this->conn->lastInsertId();
        $this->db->disconnect();

        return $id ? (int)$id : false;
    }

    // ----------------- UPDATE METHODS -----------------
    /**
     * Update a product's fields
     * Returns true if updated, false otherwise
     */
    public function updateProduct(Product $product): bool
    {
        $this->conn = $this->db->connect();

        $productId = (int)$product->getId();

        $fields = [];
        $params = [':product_id' => $productId];

        // Update standard product fields from model
        $fields[] = "name = :name";
        $params[':name'] = $product->getName();

        $fields[] = "description = :description";
        $params[':description'] = $product->getDescription();

        $fields[] = "dish_type = :dish_type";
        $params[':dish_type'] = $product->getDishType();

        $fields[] = "price = :price";
        $params[':price'] = $product->getPrice();

        $fields[] = "img_dir = :img_dir";
        $params[':img_dir'] = json_encode($product->getImgDir());

        $fields[] = "available = :available";
        $params[':available'] = (bool)$product->getAvailable();

        $query = "UPDATE product SET " . implode(", ", $fields) . " WHERE id_product = :product_id";
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $updated = $stmt->rowCount() > 0;

        $this->db->disconnect();

        return $updated;
    }

    // ----------------- DELETE METHODS -----------------
    /**
     * Delete a product from the database. 
     * Returns true if a row was deleted, false otherwise.
     */
    public function deleteProduct(int $productId): bool
    {
        $this->conn = $this->db->connect();
        
        $query = "DELETE FROM product WHERE id_product = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $deleted = $stmt->rowCount() > 0;
        
        $this->db->disconnect();
        
        return $deleted;
    }
}