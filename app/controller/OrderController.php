<?php

require_once DAO_PATH . 'OrdersDAO.php';
require_once DAO_PATH . 'OrderLineDAO.php';
require_once DAO_PATH . 'ProductDAO.php';
require_once UTIL_PATH . 'ShopCartUtils.php';
require_once UTIL_PATH . 'SessionUtils.php';

class OrderController
{
    /**
     * Show the order id details
     */
    public function show()
    {
        $view = 'order/show.php';
        SessionUtils::requireLogin('?controller=Auth&action=login');

        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $userId = SessionUtils::getUserId();

        if ($orderId <= 0) {
            header('Location: ?controller=Order&action=index');
            exit;
        }

        $ordersDAO = new OrdersDAO();
        $order = $ordersDAO->getOrderById($orderId);

        if (!$order || $order->getUserId() !== $userId) {
            header('Location: ?controller=Error&action=show&code=403&message=Forbidden');
            exit;
        }

        $orderLineDAO = new OrderLineDAO();
        $productDAO = new ProductDAO();
        
        $orderLines = $orderLineDAO->getOrderLinesByOrderId($orderId);
        $products = [];

        foreach ($orderLines as $line) {
            $productId = $line->getProductId();
            if (!isset($products[$productId])) {
                $productList = $productDAO->getProductsByFilter(['id' => $productId]);
                if (!empty($productList)) {
                    $products[$productId] = $productList[0];
                }
            }
        }

        $orderTotals = ShopCartUtils::calculateOrderTotals($orderId);
        $discount = $orderTotals['discount_obj'] ?? null;
        unset($orderTotals['discount_obj']);

        include_once VIEW_PATH . 'main.php';
    }


    /**
     * Show cart page, showing the "pending" order of the logged user
     */
    public function showCart()
    {
        $view = 'order/show.php';
        SessionUtils::requireLogin('?controller=Auth&action=login');

        $userId = SessionUtils::getUserId();
        
        $cartPendingOrder = ShopCartUtils::getUserCart($userId);
        $order = $cartPendingOrder;
        $orderLines = [];
        $products = [];
        $orderTotals = [
            'subtotal' => 0.0,
            'iva_amount' => 0.0,
            'discount_amount' => 0.0,
            'total_amount' => 0.0,
            'discount_percentage' => 0
        ];

        if ($cartPendingOrder) {
            $orderLineDAO = new OrderLineDAO();
            $productDAO = new ProductDAO();
            
            $orderLines = $orderLineDAO->getOrderLinesByOrderId($cartPendingOrder->getId());
            
            foreach ($orderLines as $orderLine) {
                $productId = $orderLine->getProductId();
                if (!isset($products[$productId])) {
                    $productList = $productDAO->getProductsByFilter(['id' => $productId]);
                    if (!empty($productList)) {
                        $products[$productId] = $productList[0];
                    }
                }
            }
            
            $orderTotals = ShopCartUtils::calculateOrderTotals($cartPendingOrder->getId());
            $discount = $orderTotals['discount_obj'] ?? null;
            unset($orderTotals['discount_obj']);
        }

        include_once VIEW_PATH . 'main.php';
    }

    /**
     * Display all orders of the logged user
     */
    public function index()
    {
        $view = 'order/index.php';
        SessionUtils::requireLogin('?controller=Auth&action=login');

        $userId = SessionUtils::getUserId();
        $ordersDAO = new OrdersDAO();
        
        $orders = $ordersDAO->getOrdersByFilter([
            'user_id' => $userId
        ], 'date_desc');

        include_once VIEW_PATH . 'main.php';
    }

    /**
     * Add a product to cart
     * Expected POST params: product_id, quantity (optional, default 1)
     */
    public function addToCart()
    {
        SessionUtils::requireLogin('?controller=Auth&action=login');

        $userId = SessionUtils::getUserId();
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($productId <= 0 || $quantity <= 0) {
            header('Location: ?controller=Product&action=index');
            exit;
        }

        $productDAO = new ProductDAO();
        $products = $productDAO->getProductsByFilter(['id' => $productId]);
        
        if (empty($products)) {
            header('Location: ?controller=Error&action=show&code=404&message=Product+not+found');
            exit;
        }

        $product = $products[0];

        if (!$product->getAvailable()) {
            header('Location: ?controller=Product&action=show&id=' . $productId . '&error=unavailable');
            exit;
        }

        $lineId = ShopCartUtils::addProductToCart($userId, $product, $quantity);

        if ($lineId) {
            SessionUtils::setFlashHttpResponse(200, 'Product added to cart successfully!');
            header('Location: ?controller=Order&action=showCart');
        } else {
            SessionUtils::setFlashHttpResponse(400, 'Failed to add product to cart.');
            header('Location: ?controller=Product&action=show&id=' . $productId);
        }
        exit;
    }

    /**
     * Update cart item quantity or table assignment
     */
    public function updateCartItem()
    {
        SessionUtils::requireLogin('?controller=Auth&action=login');
        $userId = SessionUtils::getUserId();

        if (isset($_POST['table_id'])) {
            $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
            $tableId = (int)$_POST['table_id'];

            $ordersDAO = new OrdersDAO();
            $order = $ordersDAO->getOrderById($orderId);
            
            $order->setTableId($tableId);
            $success = $ordersDAO->updateOrder($order);

            if ($success) {
                SessionUtils::setFlashHttpResponse(200, 'Table updated successfully!');
            } else {
                SessionUtils::setFlashHttpResponse(400, 'Failed to update table.');
            }

            header('Location: ?controller=Order&action=showCart');
            exit;
        }

        $lineId = isset($_POST['line_id']) ? (int)$_POST['line_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

        if ($lineId <= 0) {
            SessionUtils::setFlashHttpResponse(400, 'Invalid line item.');
            header('Location: ?controller=Order&action=showCart');
            exit;
        }

        $success = ShopCartUtils::updateCartQuantity($lineId, $quantity);

        if ($success) {
            SessionUtils::setFlashHttpResponse(200, 'Cart updated successfully!');
        } else {
            SessionUtils::setFlashHttpResponse(400, 'Failed to update cart.');
        }
        header('Location: ?controller=Order&action=showCart');
        exit;
    }

    /**
     * Remove item from cart
     * Expected POST params: line_id
     */
    public function removeFromCart()
    {
        SessionUtils::requireLogin('?controller=Auth&action=login');

        $lineId = isset($_POST['line_id']) ? (int)$_POST['line_id'] : 0;

        if ($lineId <= 0) {
            SessionUtils::setFlashHttpResponse(400, 'Invalid line item.');
            header('Location: ?controller=Order&action=showCart');
            exit;
        }

        $success = ShopCartUtils::removeFromCart($lineId);

        if ($success) {
            SessionUtils::setFlashHttpResponse(200, 'Item removed from cart!');
        } else {
            SessionUtils::setFlashHttpResponse(400, 'Failed to remove item from cart.');
        }
        header('Location: ?controller=Order&action=showCart');
        exit;
    }

    /** HELPER */
    /**
     * Checkout order to "confirmed" status
     */
    public function confirmOrder()
    {
        SessionUtils::requireLogin('?controller=Auth&action=login');

        $userId = SessionUtils::getUserId();
        $cartPendingOrder = ShopCartUtils::getUserCart($userId);

        if (!$cartPendingOrder) {
            SessionUtils::setFlashHttpResponse(400, 'Your cart is empty!');
            header('Location: ?controller=Order&action=showCart');
            exit;
        }

        $ordersDAO = new OrdersDAO();
        $cartPendingOrder->setOrderStatus('confirmed');
        $success = $ordersDAO->updateOrder($cartPendingOrder);

        if ($success) {
            SessionUtils::setFlashHttpResponse(200, 'Order confirmed successfully!');
            header('Location: ?controller=Order&action=show&id=' . $cartPendingOrder->getId());
        } else {
            SessionUtils::setFlashHttpResponse(400, 'Failed to confirm order.');
            header('Location: ?controller=Order&action=showCart');
        }
        exit;
    }
}