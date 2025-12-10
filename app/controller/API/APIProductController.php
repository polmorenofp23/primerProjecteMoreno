<?php

require_once DAO_PATH . 'ProductDAO.php';
require_once DAO_PATH . 'ProductIngredientDAO.php';
require_once UTIL_PATH . 'JsonUtils.php';

class APIProductController
{
	/**
	 * List products (optionally filtered by dish_type or available)
	 * Responds with JSON: { status, data: Product[] }
	 */
	// GET /api?resource=Product
	public function index()
	{
		$dao = new ProductDAO();

		// Build filters from query parameters (same semantics as ProductController::index)
		$filters = [];

		if (isset($_GET['dish_type']) && $_GET['dish_type'] !== '') {
			$val = trim($_GET['dish_type']);
			if (strpos($val, ',') !== false) {
				$filters['dish_type'] = array_map('trim', explode(',', $val));
			} else {
				$filters['dish_type'] = $val;
			}
		}

		if (isset($_GET['available'])) {
			$filters['available'] = (bool)intval($_GET['available']);
		}

		if (isset($_GET['price_min']) || isset($_GET['price_max'])) {
			$min = isset($_GET['price_min']) ? floatval($_GET['price_min']) : 0.0;
			$max = isset($_GET['price_max']) ? floatval($_GET['price_max']) : 0.0;
			$filters['price_range'] = [$min, $max];
		}

		if (isset($_GET['ingredient_category']) && $_GET['ingredient_category'] !== '') {
			$val = trim($_GET['ingredient_category']);
			if (strpos($val, ',') !== false) {
				$filters['ingredient_category'] = array_map('trim', explode(',', $val));
			} else {
				$filters['ingredient_category'] = $val;
			}
		}

		if (isset($_GET['contains_allergen']) && $_GET['contains_allergen'] !== '') {
			$val = trim($_GET['contains_allergen']);
			if (strpos($val, ',') !== false) {
				$filters['contains_allergen'] = array_map('intval', array_map('trim', explode(',', $val)));
			} else {
				$filters['contains_allergen'] = intval($val);
			}
		}
		if (isset($_GET['without_allergen']) && $_GET['without_allergen'] !== '') {
			$val = trim($_GET['without_allergen']);
			if (strpos($val, ',') !== false) {
				$filters['without_allergen'] = array_map('intval', array_map('trim', explode(',', $val)));
			} else {
				$filters['without_allergen'] = intval($val);
			}
		}

		if (isset($_GET['ids']) && $_GET['ids'] !== '') {
			$filters['id'] = array_map('intval', array_map('trim', explode(',', $_GET['ids'])));
		}

		$orderBy = $_GET['order_by'] ?? null;

		$products = $dao->getProductsByFilter($filters, $orderBy);

		JsonUtils::jsonResponse(JsonUtils::serializeArray($products, 'serializeProduct', $this));
	}

	/**
	 * Retrieve a single product by ID, including its ingredients
	 * Responds with JSON: { status, data: Product }
	 */
	// GET /api?resource=Product&id=123
	public function show($id)
	{
		$dao = new ProductDAO();
		$product = $dao->getProductsByFilter(['id' => (int)$id])[0] ?? null;

		if (!$product) {
			return JsonUtils::jsonError('Not found', ['data' => null], 404);
		}

		// Load ingredients as well
		$piDao = new ProductIngredientDAO();
		$ingredients = $piDao->getIngredientsByProduct((int)$id);
		$product->setIngredients($ingredients);

		JsonUtils::jsonResponse(JsonUtils::serializeItem($product, 'serializeProduct', $this));
	}

	/**
	 * Create a new product (placeholder until DAO create is implemented)
	 * Responds with JSON: { status, data: { message, payload } }
	 */
	// POST /api?resource=Product
	public function store()
	{
		$data = JsonUtils::readJsonBody();
		if ($data === null) {
			return JsonUtils::jsonError('Invalid JSON body', ['data' => null], 400);
		}

		// Basic validation
		$name = trim($data['name'] ?? '');
		$dishType = trim($data['dish_type'] ?? '');
		$price = isset($data['price']) ? (float)$data['price'] : null;
		$available = isset($data['available']) ? (int)$data['available'] : 1;
		$description = $data['description'] ?? null;
		$imgDir = $data['img_dir'] ?? null;

		$errors = [];
		if ($name === '') $errors[] = 'name is required';
		if ($dishType === '') $errors[] = 'dish_type is required';
		if ($price === null || $price < 0) $errors[] = 'price must be >= 0';

		if (!empty($errors)) {
			return JsonUtils::jsonError('Validation error', ['errors' => $errors], 422);
		}

		$productData = [
			'name' => $name,
			'description' => $description,
			'dish_type' => $dishType,
			'price' => $price,
			'img_dir' => $imgDir,
			'available' => $available,
		];

		$dao = new ProductDAO();
		$product = new Product($productData);
		$createdId = $dao->createProduct($product);
		
		if (!$createdId) {
			return JsonUtils::jsonError('Failed to create product', ['data' => null], 500);
		}
		
		$created = $dao->getProductsByFilter(['id' => $createdId]);
		return JsonUtils::jsonResponse(JsonUtils::serializeItem($created, 'serializeProduct', $this), 201);
	}

	/**
	 * Update product fields by ID (placeholder until DAO update is implemented)
	 * Responds with JSON: { status, data: { message, payload } }
	 */
	// PUT/PATCH /api?resource=Product&id=123
	public function update($id)
	{
		$dao = new ProductDAO();
		$product = $dao->getProductsByFilter(['id' => (int)$id])[0] ?? null;
		if (!$product) {
			return JsonUtils::jsonError('Not found', ['data' => null], 404);
		}

		$data = JsonUtils::readJsonBody();
		if ($data === null) {
			return JsonUtils::jsonError('Invalid JSON body', ['data' => null], 400);
		}

		// Allowed fields - apply to model via setters
		$allowed = ['name','description','dish_type','price','img_dir','available'];
		foreach ($allowed as $field) {
			if (array_key_exists($field, $data)) {
				switch ($field) {
					case 'name':
						$product->setName($data['name']);
						break;
					case 'description':
						$product->setDescription($data['description']);
						break;
					case 'dish_type':
						$product->setDishType($data['dish_type']);
						break;
					case 'price':
						$priceVal = (float)$data['price'];
						if ($priceVal < 0) return JsonUtils::jsonError('Validation error', ['errors' => ['price must be >= 0']], 422);
						$product->setPrice($priceVal);
						break;
					case 'img_dir':
						$product->setImgDir($data['img_dir']);
						break;
					case 'available':
						$product->setAvailable((bool)$data['available']);
						break;
				}
			}
		}

		$ok = $dao->updateProduct($product);
		
		if (!$ok) {
			return JsonUtils::jsonError('No changes made or update failed', ['data' => null], 400);
		}
		
		$updated = $dao->getProductsByFilter(['id' => (int)$id])[0] ?? null;
		return JsonUtils::jsonResponse(JsonUtils::serializeItem($updated, 'serializeProduct', $this));
	}

	/**
	 * Delete a product by ID
	 * Responds with JSON: { status, data: { deleted: true } }
	 */
	// DELETE /api?resource=Product&id=123
	public function destroy($id)
	{
		$dao = new ProductDAO();
		$deleted = $dao->deleteProduct((int)$id);
		if (!$deleted) {
			return JsonUtils::jsonError('Not found', ['data' => null], 404);
		}
		return JsonUtils::jsonResponse(['deleted' => true]);
	}

	// ---------- Helpers ----------

	/**
	 * Transform a Product model into a plain array for JSON
	 */
	public function serializeProduct($product)
	{
		if (!$product) return null;
		return [
			'id' => $product->getId(),
			'name' => $product->getName(),
			'description' => $product->getDescription(),
			'dish_type' => $product->getDishType(),
			'price' => $product->getPrice(),
			'img_dir' => $product->getImgDir(),
			'available' => $product->getAvailable(),
			'created_at' => $product->getCreatedAt(),
			'updated_at' => $product->getUpdatedAt(),
			'ingredients' => $this->serializeProductIngredients($product->getIngredients()),
		];
	}

	/**
	 * Transform ProductIngredient list into arrays for JSON
	 */
	public function serializeProductIngredients($ingredients)
	{
		if (!is_array($ingredients)) return [];
		return JsonUtils::serializeArray($ingredients, function($pi) {
			return [
				'ingredient_id' => method_exists($pi, 'getIngredientId') ? $pi->getIngredientId() : null,
				'grams_per_portion' => method_exists($pi, 'getGramsPerPortion') ? $pi->getGramsPerPortion() : null,
				'portion_price' => method_exists($pi, 'getPortionPrice') ? $pi->getPortionPrice() : null,
				'is_default' => method_exists($pi, 'getIsDefault') ? $pi->getIsDefault() : null,
				'is_in_final_product' => method_exists($pi, 'getIsInFinalProduct') ? $pi->getIsInFinalProduct() : (method_exists($pi, 'getIsDefault') ? $pi->getIsDefault() : null),
			];
		});
	}
}

