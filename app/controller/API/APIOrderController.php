<?php

require_once DAO_PATH . 'OrdersDAO.php';
require_once DAO_PATH . 'OrderLineDAO.php';
require_once DAO_PATH . 'OrderLineIngredientDAO.php';
require_once DAO_PATH . 'ProductDAO.php';
require_once DAO_PATH . 'UserDAO.php';
require_once DAO_PATH . 'DiscountDAO.php';
require_once UTIL_PATH . 'JsonUtils.php';
require_once UTIL_PATH . 'ShopCartUtils.php';

class APIOrderController
{
	/**
	 * List orders (optionally filtered by user_id, order_status, payment_status)
	 * Responds with JSON: { status, data: Order[] }
	 */
	// GET /?controller=api&resource=Order
	public function index()
	{
		$oDao = new OrdersDAO();
		$filters = [];

		if (isset($_GET['user_id']) && $_GET['user_id'] !== '') {
			$filters['user_id'] = (int)$_GET['user_id'];
		}

		if (isset($_GET['order_status']) && $_GET['order_status'] !== '') {
			$val = trim($_GET['order_status']);
			if (strpos($val, ',') !== false) {
				$filters['order_status'] = array_map('trim', explode(',', $val));
			} else {
				$filters['order_status'] = $val;
			}
		}

		if (isset($_GET['payment_status']) && $_GET['payment_status'] !== '') {
			$val = trim($_GET['payment_status']);
			if (strpos($val, ',') !== false) {
				$filters['payment_status'] = array_map('trim', explode(',', $val));
			} else {
				$filters['payment_status'] = $val;
			}
		}

		if (isset($_GET['ids']) && $_GET['ids'] !== '') {
			$filters['id'] = array_map('intval', array_map('trim', explode(',', $_GET['ids'])));
		}

		$orderBy = $_GET['order_by'] ?? 'date_desc';
		$orders = $oDao->getOrdersByFilter($filters, $orderBy);
		JsonUtils::jsonResponse(JsonUtils::serializeArray($orders, 'serializeOrder', $this));
	}

	/**
	 * Retrieve a single order by ID, including its order lines and ingredients
	 * Responds with JSON: { status, data: Order }
	 */
	// GET /?controller=api&resource=Order&id=123
	public function show($id)
	{
		$oDao = new OrdersDAO();
		$order = $oDao->getOrderById((int)$id);
		if (!$order) {
			return JsonUtils::jsonError('Order not found', ['data' => null], 404);
		}

		$olDao = new OrderLineDAO();
		$orderLines = $olDao->getOrderLinesByOrderId((int)$id);
		$order->_orderLines = $orderLines;
		JsonUtils::jsonResponse(JsonUtils::serializeItem($order, 'serializeOrder', $this));
	}

	/**
	 * Create a new order
	 * Responds with JSON: { status, data: Order }
	 */
	// POST /?controller=api&resource=Order
	public function store()
	{
		$data = JsonUtils::readJsonBody();
		if ($data === null) {
			return JsonUtils::jsonError('Invalid JSON body', ['data' => null], 400);
		}

		$userId = isset($data['userId']) ? (int)$data['userId'] : null;
		$orderStatus = trim($data['orderStatus'] ?? 'pending');
		$paymentStatus = trim($data['paymentStatus'] ?? 'pending');
		$tableId = isset($data['tableId']) ? (int)$data['tableId'] : 1;
		$products = isset($data['products']) && is_array($data['products']) ? $data['products'] : [];

		$errors = [];
		if (!$userId) $errors[] = 'userId is required';
		if ($orderStatus === '') $errors[] = 'orderStatus is required';
		if ($paymentStatus === '') $errors[] = 'paymentStatus is required';

		if (!empty($errors)) {
			return JsonUtils::jsonError('Validation error', ['errors' => $errors], 422);
		}

		$userDao = new UserDAO();
		$user = $userDao->getUserById($userId);

		if (!$user) {
			return JsonUtils::jsonError('User not found', ['data' => null], 404);
		}

		$discountId = $this->resolveDiscountIdForUser($user);

		$orderData = [
			'id_user' => $userId,
			'order_status' => $orderStatus,
			'payment_status' => $paymentStatus,
			'total_amount' => 0.0,
			'discount_amount' => 0.0,
			'id_discount' => $discountId,
			'table_id' => $tableId,
		];

		$oDao = new OrdersDAO();
		$order = new Orders($orderData);
		$createdId = $oDao->createOrder($order);
		
		if (!$createdId) {
			return JsonUtils::jsonError('Failed to create order', ['data' => null], 500);
		}

		if (!empty($products)) {
			$productDao = new ProductDAO();
			foreach ($products as $product) {
				$productId = isset($product['productId']) ? (int)$product['productId'] : null;
				$quantity = isset($product['quantity']) ? (int)$product['quantity'] : 1;
				if (!$productId || $quantity <= 0) {
					continue;
				}

				$productObj = $productDao->getProductById($productId);
				if ($productObj) {
					ShopCartUtils::addProductToOrder($userId, $productObj, $quantity, $createdId, false);
				}
			}
			ShopCartUtils::updateOrderAmounts($createdId);
		}

		$createdOrder = $oDao->getOrderById((int)$createdId);
		$olDao = new OrderLineDAO();
		$orderLines = $olDao->getOrderLinesByOrderId((int)$createdId);
		$createdOrder->_orderLines = $orderLines;

		$response = JsonUtils::serializeItem($createdOrder, 'serializeOrder', $this);
		return JsonUtils::jsonResponse($response, 201);
	}

	/**
	 * Update order fields by ID
	 * Responds with JSON: { status, data: Order }
	 */
	// PUT/PATCH /?controller=api&resource=Order&id=123
	public function update($id)
	{
		$oDao = new OrdersDAO();
		$order = $oDao->getOrderById((int)$id);
		if (!$order) {
			return JsonUtils::jsonError('Order not found', ['data' => null], 404);
		}

		$data = JsonUtils::readJsonBody();
		if ($data === null) {
			return JsonUtils::jsonError('Invalid JSON body', ['data' => null], 400);
		}

		$updateData = [];
		if (isset($data['userId'])) $updateData['userId'] = $data['userId'];
		if (isset($data['orderStatus'])) $updateData['orderStatus'] = $data['orderStatus'];
		if (isset($data['paymentStatus'])) $updateData['paymentStatus'] = $data['paymentStatus'];
		if (isset($data['tableId'])) $updateData['tableId'] = $data['tableId'];

		if (empty($updateData) && !isset($data['orderLines'])) {
			return JsonUtils::jsonError('No changes provided', ['data' => null], 400);
		}

		$lineResults = ['added' => 0, 'updated' => 0, 'deleted' => 0, 'errors' => []];
		
		if (isset($data['orderLines']) && is_array($data['orderLines'])) {
			$productDao = new ProductDAO();
			foreach ($data['orderLines'] as $line) {
				$action = strtolower(trim($line['action'] ?? 'update'));
				$lineId = isset($line['lineId']) ? (int)$line['lineId'] : null;
				$productId = isset($line['productId']) ? (int)$line['productId'] : null;
				$quantity = isset($line['quantity']) ? (int)$line['quantity'] : 1;

				if ($action === 'delete' && $lineId) {
					if (ShopCartUtils::removeOrderLine($lineId, (int)$id)) {
						$lineResults['deleted']++;
					} else {
						$lineResults['errors'][] = "Failed to delete line {$lineId}";
					}
					continue;
				}

				if ($action === 'add' && $productId && $quantity > 0) {
					$productObj = $productDao->getProductById($productId);
					if ($productObj) {
						$newLineId = ShopCartUtils::addProductToOrder($order->getUserId(), $productObj, $quantity, (int)$id);
						if ($newLineId) {
							$lineResults['added']++;
						} else {
							$lineResults['errors'][] = "Failed to add product {$productId}";
						}
					}
					continue;
				}

				if ($action === 'update' && $lineId) {
					if (ShopCartUtils::updateOrderLineQuantity($lineId, $quantity, (int)$id)) {
						$lineResults['updated']++;
					} else {
						$lineResults['errors'][] = "Failed to update line {$lineId}";
					}
					continue;
				}
			}
		}

		if (!empty($updateData)) {
			if (!ShopCartUtils::updateOrderFields((int)$id, $updateData)) {
				return JsonUtils::jsonError('Failed to update order fields', ['data' => null], 500);
			}
		}
		
		$updated = $oDao->getOrderById((int)$id);
		$olDao = new OrderLineDAO();
		$olList = $olDao->getOrderLinesByOrderId((int)$id);
		$updated->_orderLines = $olList;

		$response = JsonUtils::serializeItem($updated, 'serializeOrder', $this);
		$response['line_changes'] = $lineResults;
		return JsonUtils::jsonResponse($response);
	}

	/**
	 * Delete an order by ID
	 * Responds with JSON: { status, data: { deleted: true } }
	 */
	// DELETE /?controller=api&resource=Order&id=123
	public function destroy($id)
	{
        $oDao = new OrdersDAO();
		$olDao = new OrderLineDAO();
		$oliDao = new OrderLineIngredientDAO();
		
		$orderLines = $olDao->getOrderLinesByOrderId((int)$id);
		foreach ($orderLines as $line) {
			$oliDao->removeAllIngredientsFromOrderLine($line->getId());
		}
		
		$olDao->deleteOrderLinesByOrderId((int)$id);
		$deleted = $oDao->deleteOrder((int)$id);	
		if (!$deleted) {
			return JsonUtils::jsonError('Order not found', ['data' => null], 404);
		}
		return JsonUtils::jsonResponse(['deleted' => true]);
	}

	private function resolveDiscountIdForUser(User $user): ?int
	{
		$userTypeId = $user->getUserTypeId();
		if (!$userTypeId) {
			return null;
		}

		$discountDao = new DiscountDAO();
		$discount = $discountDao->getDiscountByUserType($userTypeId);
		if ($discount && $discount->getStatus() === 'active') {
			return $discount->getId();
		}

		return null;
	}

	// ---------- HELPERS ----------
	/**
	 * Transform an Order model into a plain array for JSON
	 */
	public function serializeOrder($order)
	{
		if (!$order) return null;
		$orderLines = isset($order->_orderLines) ? $order->_orderLines : [];
		
		if (empty($orderLines) && $order->getId()) {
			$olDao = new OrderLineDAO();
			$orderLines = $olDao->getOrderLinesByOrderId($order->getId());
		}
		return [
			'id' => $order->getId(),
			'userId' => $order->getUserId(),
			'idDiscount' => $order->getDiscountId(),
			'totalAmount' => $order->getTotalAmount(),
			'discountAmount' => $order->getDiscountAmount(),
			'tableId' => $order->getTableId(),
			'orderStatus' => $order->getOrderStatus(),
			'paymentStatus' => $order->getPaymentStatus(),
			'createdAt' => $order->getCreatedAt(),
			'updatedAt' => $order->getUpdatedAt(),
			'orderLines' => $this->serializeOrderLines($orderLines),
		];
	}

	/**
	 * Transform OrderLine list into arrays for JSON
	 */
	public function serializeOrderLines($orderLines)
	{
		if (!is_array($orderLines)) return [];
		return JsonUtils::serializeArray($orderLines, 'serializeOrderLine', $this);
	}

	/**
	 * Transform an OrderLine model into a plain array for JSON
	 */
	public function serializeOrderLine($orderLine)
	{
		if (!$orderLine) return null;
		return [
			'lineId' => $orderLine->getId(),
			'orderId' => $orderLine->getOrderId(),
			'productId' => $orderLine->getProductId(),
			'quantity' => $orderLine->getQuantity(),
			'unitPrice' => $orderLine->getUnitPrice(),
			'ingredients' => $this->serializeOrderLineIngredients($orderLine->getIngredients()),
		];
	}

	/**
	 * Transform OrderLineIngredient list into arrays for JSON
	 */
	public function serializeOrderLineIngredients($ingredients)
	{
		if (!is_array($ingredients)) return [];
		return JsonUtils::serializeArray($ingredients, 'serializeOrderLineIngredient', $this);
	}

	/**
	 * Transform an OrderLineIngredient model into a plain array for JSON
	 */
	public function serializeOrderLineIngredient($oli)
	{
		if (!$oli) return null;
		return [
			'lineIngredientId' => method_exists($oli, 'getId') ? $oli->getId() : null,
			'lineId' => method_exists($oli, 'getLineId') ? $oli->getLineId() : null,
			'ingredientId' => method_exists($oli, 'getIngredientId') ? $oli->getIngredientId() : null,
			'numPortions' => method_exists($oli, 'getNumPortions') ? $oli->getNumPortions() : null,
			'ingredientPrice' => method_exists($oli, 'getIngredientPrice') ? $oli->getIngredientPrice() : null,
			'grams' => method_exists($oli, 'getGrams') ? $oli->getGrams() : null,
			'kcalComponent' => method_exists($oli, 'getKcalComponent') ? $oli->getKcalComponent() : null,
			'proteinG' => method_exists($oli, 'getProteinG') ? $oli->getProteinG() : null,
			'carbsG' => method_exists($oli, 'getCarbsG') ? $oli->getCarbsG() : null,
			'fatG' => method_exists($oli, 'getFatG') ? $oli->getFatG() : null,
			'origin' => method_exists($oli, 'getOrigin') ? $oli->getOrigin() : null,
			'doneness' => method_exists($oli, 'getDoneness') ? $oli->getDoneness() : null,
		];
	}
}
