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
	// GET /?controller=api&resource=Product
	public function index()
	{
		$pDao = new ProductDAO();
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

		if (isset($_GET['ids']) && $_GET['ids'] !== '') {
			$filters['id'] = array_map('intval', array_map('trim', explode(',', $_GET['ids'])));
		}

		$orderBy = $_GET['order_by'] ?? null;

		$products = $pDao->getProductsByFilter($filters, $orderBy);

		JsonUtils::jsonResponse(JsonUtils::serializeArray($products, 'serializeProduct', $this));
	}

	/**
	 * Retrieve a single product by ID, including its ingredients
	 * Responds with JSON: { status, data: Product }
	 */
	// GET /?controller=api&resource=Product&id=123
	public function show($id)
	{
		$pDao = new ProductDAO();
		$product = $pDao->getProductsByFilter(['id' => (int)$id])[0] ?? null;

		if (!$product) {
			return JsonUtils::jsonError('Not found', ['data' => null], 404);
		}

		$piDao = new ProductIngredientDAO();
		$ingredients = $piDao->getIngredientsByProduct((int)$id);
		$product->setIngredients($ingredients);

		JsonUtils::jsonResponse(JsonUtils::serializeItem($product, 'serializeProduct', $this));
	}

	/**
	 * Create a new product (placeholder until DAO create is implemented)
	 * Responds with JSON: { status, data: { message, payload } }
	 */
	// POST /?controller=api&resource=Product
	public function store()
	{
		$data = JsonUtils::readJsonBody();
		if ($data === null) {
			return JsonUtils::jsonError('Invalid JSON body', ['data' => null], 400);
		}

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

		$pDao = new ProductDAO();
		$product = new Product($productData);
		$createdId = $pDao->createProduct($product);
		
		if (!$createdId) {
			return JsonUtils::jsonError('Failed to create product', ['data' => null], 500);
		}
		
		$piDao = new ProductIngredientDAO();
		$addedCount = 0;
		// Expect exactly `productIngredients` array with camelCase fields from frontend
		if (isset($data['productIngredients']) && is_array($data['productIngredients'])) {
			$normalized = [];
			foreach ($data['productIngredients'] as $ing) {
				$normalized[] = [
					'id_product' => (int)$createdId,
					'id_ingredient' => (int)$ing['ingredientId'],
					'grams_per_portion' => (float)$ing['gramsPerPortion'],
					'portion_price' => (float)$ing['portionPrice'],
					'is_default' => (bool)$ing['isDefault'],
				];
			}
			$addedCount = $piDao->addMultipleIngredientsToProduct((int)$createdId, $normalized);
		}
		
		$created = $pDao->getProductsByFilter(['id' => $createdId]);
		$response = JsonUtils::serializeItem($created, 'serializeProduct', $this);
		$response['ingredient_changes'] = ['added' => $addedCount];
		return JsonUtils::jsonResponse($response, 201);
	}

	/**
	 * Update product fields by ID (placeholder until DAO update is implemented)
	 * Responds with JSON: { status, data: { message, payload } }
	 */
	// PUT/PATCH /?controller=api&resource=Product&id=123
	public function update($id)
	{
		$pDao = new ProductDAO();
		$product = $pDao->getProductsByFilter(['id' => (int)$id])[0] ?? null;
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

		$ok = $pDao->updateProduct($product);
		
		// Process ingredient modifications if provided. Accepts array of ingredient objects.
		// Each ingredient may include an optional 'action' field: 'add', 'update', 'delete'.
		$piDao = new ProductIngredientDAO();
		$ingredientResults = ['added' => 0, 'updated' => 0, 'deleted' => 0];
		// Expect exactly `productIngredients` array with camelCase fields from frontend
		if (isset($data['productIngredients']) && is_array($data['productIngredients'])) {
			foreach ($data['productIngredients'] as $ing) {
				$ingredientId = (int)$ing['ingredientId'];
				$action = strtolower(trim($ing['action'] ?? ''));
				$piData = [
					'id_product' => (int)$id,
					'id_ingredient' => $ingredientId,
					'grams_per_portion' => (float)$ing['gramsPerPortion'],
					'portion_price' => (float)$ing['portionPrice'],
					'is_default' => (bool)$ing['isDefault'],
				];
				$pi = new ProductIngredient($piData);
				if ($action === 'add') {
					if ($piDao->addIngredientToProduct($pi)) $ingredientResults['added']++;
					continue;
				}
				if ($action === 'delete') {
					if ($piDao->deleteIngredientFromProduct((int)$id, $ingredientId)) $ingredientResults['deleted']++;
					continue;
				}
				// default to update if no explicit 'add' or 'delete'
				if ($piDao->updateIngredientFromProduct($pi)) $ingredientResults['updated']++;
			}
		}
		
		if (!$ok && $ingredientResults['added'] + $ingredientResults['updated'] + $ingredientResults['deleted'] === 0) {
			return JsonUtils::jsonError('No changes made or update failed', ['data' => null], 400);
		}
		
		$updated = $pDao->getProductsByFilter(['id' => (int)$id])[0] ?? null;
		$response = JsonUtils::serializeItem($updated, 'serializeProduct', $this);
		$response['ingredient_changes'] = $ingredientResults;
		return JsonUtils::jsonResponse($response);
	}

	/**
	 * Delete a product by ID
	 * Responds with JSON: { status, data: { deleted: true } }
	 */
	// DELETE /?controller=api&resource=Product&id=123
	public function destroy($id)
	{
		$piDao = new ProductIngredientDAO();
		$piDao->deleteAllIngredientsFromProduct((int)$id);
		
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
			'dishType' => $product->getDishType(),
			'price' => $product->getPrice(),
			'imgDir' => $product->getImgDir(),
			'available' => $product->getAvailable(),
			'createdAt' => $product->getCreatedAt(),
			'updatedAt' => $product->getUpdatedAt(),
			'productIngredients' => $this->serializeProductIngredients($product->getIngredients()),
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
				'productId' => method_exists($pi, 'getProductId') ? $pi->getProductId() : null,
				'ingredientId' => method_exists($pi, 'getIngredientId') ? $pi->getIngredientId() : null,
				'gramsPerPortion' => method_exists($pi, 'getGramsPerPortion') ? $pi->getGramsPerPortion() : null,
				'portionPrice' => method_exists($pi, 'getPortionPrice') ? $pi->getPortionPrice() : null,
				'isDefault' => method_exists($pi, 'getIsDefault') ? $pi->getIsDefault() : null,
			];
		});
	}
}

