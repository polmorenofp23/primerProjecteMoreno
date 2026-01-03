<?php

require_once DAO_PATH . 'OrdersDAO.php';
require_once DAO_PATH . 'OrderLineDAO.php';
require_once DAO_PATH . 'OrderLineIngredientDAO.php';
require_once DAO_PATH . 'ProductDAO.php';
require_once DAO_PATH . 'IngredientDAO.php';
require_once DAO_PATH . 'DiscountDAO.php';
require_once DAO_PATH . 'UserDAO.php';
require_once MODEL_PATH . 'Orders.php';
require_once MODEL_PATH . 'OrderLine.php';
require_once MODEL_PATH . 'OrderLineIngredient.php';

class ShopCartUtils
{
    /**
     * Get or create a pending order for the user
     * If creating a new order, applies user type discount if available
     */
    public static function getOrCreatePendingOrder(int $userId): int
    {
        $ordersDAO = new OrdersDAO();
        $pendingOrders = $ordersDAO->getOrdersByFilter([ // Check if user has a pending order
            'user_id' => $userId,
            'order_status' => 'pending'
        ], 'date_desc');
        
        if (!empty($pendingOrders)) {
            return $pendingOrders[0]->getId();
        }
        
        $userDAO = new UserDAO();
        $user = $userDAO->getUserById($userId);
        $discountId = null;
        if ($user) {
            $userTypeId = $user->getUserTypeId();
            if ($userTypeId) {
                $discountDAO = new DiscountDAO();
                $discount = $discountDAO->getDiscountByUserType($userTypeId);
                
                if ($discount) {
                    $discountId = $discount->getId();
                }
            }
        }
        
        $newOrder = new Orders([    // Create new pending order
            'id_user' => $userId,
            'total_amount' => 0.0,
            'discount_amount' => 0.0,
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'id_discount' => $discountId,
            'table_id' => 1
        ]);
        
        $orderId = $ordersDAO->createOrder($newOrder);
        
        if (!$orderId) {
            throw new Exception("Failed to create order for user $userId");
        }
        
        return $orderId;
    }

    /**
     * Get the current cart (pending order) for a user
     * Returns Orders object with order lines populated, or null if no cart exists
     */
    public static function getUserCart(int $userId): ?Orders
    {
        try {
            $ordersDAO = new OrdersDAO();
            $pendingOrders = $ordersDAO->getOrdersByFilter([
                'user_id' => $userId,
                'order_status' => 'pending'
            ], 'date_desc');
            
            if (empty($pendingOrders)) {
                return null;
            }
            
            return $pendingOrders[0];
            
        } catch (Exception $e) {
            error_log("Error getting user cart: " . $e->getMessage());
            return null;
        }
    }

    /* ADD */
    /**
     * Add a product to the user's cart (pending order)
     * Converts Product with ProductIngredients to OrderLine with OrderLineIngredients
     */
    public static function addProductToCart(int $userId, Product $product, int $quantity = 1)
    {
        try {
            $orderId = self::getOrCreatePendingOrder($userId);
            $orderLine = new OrderLine([
                'id_order' => $orderId,
                'id_product' => $product->getId(),
                'quantity' => $quantity,
                'unit_price' => $product->getPrice()
            ]);
            
            $orderLineDAO = new OrderLineDAO();
            $lineId = $orderLineDAO->createOrderLine($orderLine);
            
            if (!$lineId) {
                return false;
            }
            
            $productIngredients = $product->getFinalIngredients();
            if (empty($productIngredients)) {
                $productIngredients = $product->getDefaultIngredients();
            }
            
            $ingredientDAO = new IngredientDAO();
            $orderLineIngredientDAO = new OrderLineIngredientDAO();
            
            foreach ($productIngredients as $pi) {
                $ingredientId = null;
                $gramsPerPortion = 0.0;
                $portionPrice = 0.0;
                $isDefault = true;
                
                if ($pi instanceof ProductIngredient) {
                    $ingredientId = $pi->getIngredientId();
                    $gramsPerPortion = $pi->getGramsPerPortion();
                    $portionPrice = $pi->getPortionPrice();
                    $isDefault = $pi->getIsDefault();
                } elseif (is_array($pi)) {
                    $ingredientId = $pi['id_ingredient'] ?? $pi['ingredient_id'] ?? null;
                    $gramsPerPortion = $pi['grams_per_portion'] ?? 0.0;
                    $portionPrice = $pi['portion_price'] ?? 0.0;
                    $isDefault = $pi['is_default'] ?? true;
                }
                
                if (!$ingredientId) continue;
                $ingredient = $ingredientDAO->getIngredientById((int)$ingredientId);
                if (!$ingredient) continue;
                
                $grams = (float)$gramsPerPortion;
                $kcalPer100g = (float)$ingredient->getKcalPer100g();         
                $kcalComponent = ($grams / 100.0) * $kcalPer100g;
                
                $oli = new OrderLineIngredient([
                    'id_line' => $lineId,
                    'id_ingredient' => $ingredientId,
                    'num_portions' => 1,
                    'ingredient_price' => $portionPrice,
                    'grams' => $grams,
                    'kcal_component' => $kcalComponent,
                    'protein_g' => 0.0,
                    'carbs_g' => 0.0,
                    'fat_g' => 0.0,
                    'origin' => $isDefault ? 'default' : 'extra',
                    'doneness' => null
                ]);
                
                $orderLineIngredientDAO->addIngredientToOrderLine($oli);
            }
            
            self::updateOrderAmounts($orderId);
            
            return $lineId;
            
        } catch (Exception $e) {
            error_log("Error adding product to cart: " . $e->getMessage());
            return false;
        }
    }

    /* UPDATE */
    /**
     * Update quantity of an order line in cart
     */
    public static function updateCartQuantity(int $lineId, int $quantity): bool
    {
        try {
            if ($quantity <= 0) {
                return self::removeFromCart($lineId);
            }
            
            $orderLineDAO = new OrderLineDAO();
            $orderLine = $orderLineDAO->getOrderLineById($lineId);
            if (!$orderLine) {
                return false;
            }
            
            $orderId = $orderLine->getOrderId();
            
            $success = $orderLineDAO->updateQuantity($lineId, $quantity);
            if ($success) {
                self::updateOrderAmounts($orderId);
            }
            
            return $success;
            
        } catch (Exception $e) {
            error_log("Error updating cart quantity: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update the total and the discount amounts of an order based on its order lines
     * Also calculates IVA and saves the final total_amount in DB
     */
    public static function updateOrderAmounts(int $orderId): bool
    {
        try {
            $ordersDAO = new OrdersDAO();
            
            $totals = self::calculateOrderTotals($orderId);
            $order = $ordersDAO->getOrderById($orderId);
            if (!$order) {
                return false;
            }
            
            $order->setTotalAmount($totals['total_amount']);
            $order->setDiscountAmount($totals['discount_amount']);
            
            return $ordersDAO->updateOrder($order);
            
        } catch (Exception $e) {
            error_log("Error updating order amounts: " . $e->getMessage());
            return false;
        }
    }

    /* REMOVE */
    /**
     * Remove an order line from cart and update order total
     */
    public static function removeFromCart(int $lineId): bool
    {
        try {
            $orderLineDAO = new OrderLineDAO();
            $orderLine = $orderLineDAO->getOrderLineById($lineId);
            if (!$orderLine) {
                return false;
            }
            
            $orderId = $orderLine->getOrderId();
            $success = $orderLineDAO->deleteOrderLine($lineId); 
            if ($success) {
                self::updateOrderAmounts($orderId);
            }
            return $success;
            
        } catch (Exception $e) {
            error_log("Error removing from cart: " . $e->getMessage());
            return false;
        }
    }

    /* HELPERS */
    /**
     * Get cart items count for a user
     */
    public static function getCartItemsCount(int $userId): int
    {
        try {
            $cart = self::getUserCart($userId);
            if (!$cart) {
                return 0;
            }
            
            $orderLineDAO = new OrderLineDAO();
            $orderLines = $orderLineDAO->getOrderLinesByOrderId($cart->getId());
            
            $count = 0;
            foreach ($orderLines as $line) {
                $count += $line->getQuantity();
            }
            
            return $count;
            
        } catch (Exception $e) {
            error_log("Error getting cart items count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Calculate all order totals including subtotal, IVA, discount amount, and final total
     * Returns an array with:
     *  - subtotal: sum of all products (without IVA or discount)
     *  - iva_amount: 21% of subtotal
     *  - discount_amount: (subtotal + iva) * discount_percentage / 100
     *  - total_amount: final amount to be saved in DB (subtotal + iva - discount)
     *  - discount_percentage: percentage applied (0 if no discount)
     */
    public static function calculateOrderTotals(int $orderId): array
    {
        try {
            $orderLineDAO = new OrderLineDAO();
            $ordersDAO = new OrdersDAO();
            $discountDAO = new DiscountDAO();
            
            $orderLines = $orderLineDAO->getOrderLinesByOrderId($orderId);
            $subtotal = 0.0;
            foreach ($orderLines as $line) {
                $lineTotal = $line->getUnitPrice() * $line->getQuantity();
                $extraIngredients = $line->getExtraIngredients();
                foreach ($extraIngredients as $ing) {
                    if ($ing instanceof OrderLineIngredient) {
                        $lineTotal += $ing->getIngredientPrice() * $ing->getNumPortions();
                    } elseif (is_array($ing)) {
                        $lineTotal += ($ing['ingredient_price'] ?? 0.0) * ($ing['num_portions'] ?? 1);
                    }
                }
                $subtotal += $lineTotal;
            }
            
            $ivaAmount = $subtotal * 0.21;
            $subtotalWithIva = $subtotal + $ivaAmount;

            $order = $ordersDAO->getOrderById($orderId);
            if (!$order) {
                return [
                    'subtotal' => $subtotal,
                    'iva_amount' => $ivaAmount,
                    'discount_amount' => 0.0,
                    'total_amount' => $subtotalWithIva,
                    'discount_percentage' => 0
                ];
            }
            
            $discountAmount = 0.0;
            $discountPercentage = 0;
            $discountId = $order->getDiscountId();
            if ($discountId) {
                $discount = $discountDAO->getDiscountById($discountId);
                if ($discount && $discount->getStatus() === 'active') {
                    $discountPercentage = $discount->getPercentage();
                    $discountAmount = ($subtotalWithIva * $discountPercentage) / 100;
                }
            }
            
            $finalTotal = $subtotalWithIva - $discountAmount;   
            return [
                'subtotal' => $subtotal,
                'iva_amount' => $ivaAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $finalTotal,
                'discount_percentage' => $discountPercentage,
                'discount_obj' => $discount ?? null
            ];
            
        } catch (Exception $e) {
            error_log("Error calculating order totals: " . $e->getMessage());
            return [
                'subtotal' => 0.0,
                'iva_amount' => 0.0,
                'discount_amount' => 0.0,
                'total_amount' => 0.0,
                'discount_percentage' => 0
            ];
        }
    }
}
