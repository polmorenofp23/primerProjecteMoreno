<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= ($order && $order->getOrderStatus() !== 'pending') ? 'Order #' . $order->getId() : 'Shopping Cart' ?> - Bees Cavern</title>
</head>
<body>
    <?php
        $isPending = ($order && $order->getOrderStatus() === 'pending');
        $cartPendingOrder = $isPending ? $order : null;
    ?>
    <div class="d-flex flex-column justify-content-center align-items-center col-12">
        <div class="d-flex flex-column flex-md-row justify-content-between justify-content-md-center align-items-center col-12 my-4">
            <div class="w-100">
                <?php
                    if ($order && $order->getOrderStatus() !== 'pending') {
                        renderBCPageTitle([
                            'Order History' => '?controller=Order&action=index',
                            'Order #' . $order->getId() => null
                        ]);
                    } else {
                        renderBCPageTitle(['Shopping Cart' => null]);
                    }
                ?>
            </div>
            <?php if ($isPending && $cartPendingOrder): ?>
            <div class="col-6 col-md-3 me-5">
                <form action="?controller=Order&action=updateCartItem" method="POST" class="d-inline">
                    <input type="hidden" name="order_id" value="<?= $cartPendingOrder->getId() ?>">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <label for="table_id" class="fs-20 text-capitalize">Table Id</label>
                        <select name="table_id" class="form-select form-select-sm w-auto fs-20 border-0 w-auto" onchange="this.form.submit()">
                            <?php for ($i = 1; $i <= 16; $i++): ?>
                                <option value="<?= $i ?>" <?= $cartPendingOrder->getTableId() == $i ? 'selected' : '' ?>>
                                    <?= $i ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!$order || empty($orderLines)): ?>
            <div class="row my-5">
                <div class="col-12 text-center">
                    <i data-lucide="shopping-cart" class="icon-64 icon-grey mb-4"></i>
                    <h3 class="font-sting-light fs-32 text-primary-grey mb-4">Your cart is empty</h3>
                    <a href="?controller=Product&action=index" class="btn-red px-5 py-3 my-5">Browse Menu</a>
                </div>
            </div>
        <?php else: ?>
            <div class="col-11 col-lg-10 d-flex flex-column flex-lg-row gap-5 align-items-start mb-5">
                <div class="order-line-container col-lg-8">
                    <table id="order-lines-table" class="table w-100 font-sting-light fs-14 text-primary-black text-capitalize">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-start align-middle">Name</th>
                                <th class="text-start align-middle">Ingredients</th>
                                <th class="text-center align-middle">Dish Type</th>
                                <th class="text-center align-middle">Quantity</th>
                                <th class="text-end align-middle">Price</th>
                                <?php if ($isPending): ?>
                                <th></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="order-lines-table-body" class="align-items-center">
                            <?php foreach ($orderLines as $orderLine): ?>
                                <?php
                                    $product = $products[$orderLine->getProductId()] ?? null;
                                    if (!$product) continue;
                                    $lineTotalPrice = $orderLine->getUnitPrice() * $orderLine->getQuantity();
                                    $imgDir = $product->getImgDir();
                                    $productImg = '/assets/img/products/default.webp';
                                    if (is_array($imgDir) && !empty($imgDir)) {
                                        foreach ($imgDir as $candidate) {
                                            $candidate = (string)$candidate;
                                            if (!$candidate) continue;
                                            $fsPath = rtrim((string)$_SERVER['DOCUMENT_ROOT'], "\\/") . '/' . ltrim($candidate, '/');
                                            if (file_exists($fsPath)) {
                                                $productImg = '/' . ltrim($candidate, '/');
                                                break;
                                            }
                                        }
                                    }
                                ?>
                                <tr>
                                    <td class="align-middle">
                                        <img src="<?= htmlspecialchars($productImg) ?>" alt="<?= htmlspecialchars($product->getName()) ?>" 
                                            class="rounded-1 img-60">
                                    </td>
                                    <td class="align-middle text-start">
                                        <a href="?controller=Product&action=show&id=<?= $product->getId() ?>" 
                                            class="text-decoration-none text-primary-dark-red font-sting-regular fs-16">
                                            <?= htmlspecialchars($product->getName()) ?>
                                        </a>
                                    </td>
                                    <td class="align-middle text-start text-uppercase">DEFAULT</td>
                                    <td class="align-middle text-center text-uppercase">
                                        <?= htmlspecialchars($product->getDishType()) ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php if ($isPending): ?>
                                            <form action="?controller=Order&action=updateCartItem" class="d-inline" method="POST">
                                                <input type="hidden" name="line_id" value="<?= $orderLine->getId() ?>">
                                                <select name="quantity" class="form-select form-select-sm border-0 px-2" onchange="this.form.submit()">
                                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                                        <option value="<?= $i ?>" <?= $orderLine->getQuantity() == $i ? 'selected' : '' ?>>
                                                            <?= $i ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </form>
                                        <?php else: ?>
                                            <span class="font-karla-regular">x<?= $orderLine->getQuantity() ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle text-end">
                                        <?= number_format($lineTotalPrice, 2) ?> €
                                    </td>
                                    <?php if ($isPending): ?>
                                    <td class="align-middle text-end">
                                        <form action="?controller=Order&action=removeFromCart" method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to remove this item?');">
                                            <input type="hidden" name="line_id" value="<?= $orderLine->getId() ?>">
                                            <button type="submit" class="btn btn-sm bg-transparent border-0">
                                                <i data-lucide="trash-2" class="icon-red"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="confirm-order-box col-lg-4 mb-5">
                    <div class="card shadow-sm border-0 rounded-0 bg-secondary-white text-primary-black p-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <hr class="flex-grow-1 my-0">
                                <h3 class="font-sting-regular fs-32 text-primary-black text-nowrap">Order Summary</h3>
                                <hr class="flex-grow-1 my-0">
                            </div>
                            
                            <hr class="border-secondary-grey mb-2">

                            <?php if (!$isPending && $order): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="font-karla-regular fs-16">Table ID</span>
                                    <span class="font-karla-regular fs-16">#<?= $order->getTableId() ? $order->getTableId() : '-' ?></span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="font-karla-regular fs-16">Date</span>
                                    <span class="font-karla-regular fs-16">
                                        <?php
                                            $createdAt = $order->getCreatedAt();
                                            if ($createdAt) {
                                                $dateObj = new DateTime($createdAt);
                                                echo $dateObj->format('d/m/Y H:i');
                                            }
                                        ?>
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="font-karla-regular fs-16">Order Status</span>
                                    <span class="font-sting-regular fs-16 text-uppercase">
                                        <?= htmlspecialchars(str_replace('-', ' ', $order->getOrderStatus())) ?>
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="font-karla-regular fs-16">Payment Status</span>
                                    <span class="font-sting-regular fs-16 text-uppercase">
                                        <?= htmlspecialchars(str_replace('-', ' ', $order->getPaymentStatus())) ?>
                                    </span>
                                </div>

                                <hr class="border-secondary-grey mb-2">
                            <?php endif; ?>

                            <div class="d-flex justify-content-between mb-2 ms-3">
                                <span class="font-karla-regular fs-16">Subtotal</span>
                                <span class="font-karla-regular fs-16"><?= number_format($orderTotals['subtotal'], 2) ?> €</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2 ms-3">
                                <span class="font-karla-regular fs-16">IVA (21%)</span>
                                <span class="font-karla-regular fs-16"><?= number_format($orderTotals['iva_amount'], 2) ?> €</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="font-karla-regular fs-16 text-capitalize">Complete amount</span>
                                <span class="font-karla-regular fs-16"><?= number_format($orderTotals['subtotal'] + $orderTotals['iva_amount'], 2) ?> €</span>
                            </div>
     
                            <hr class="border-secondary-grey">
                            
                            <?php if ($orderTotals['discount_amount'] > 0 && $orderTotals['discount_percentage'] > 0 && $discount): ?>
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span class="font-karla-regular fs-16"> 
                                        <?= $discount->getName() ?> (-<?= $orderTotals['discount_percentage'] ?>%):
                                        <br>
                                        <?= $discount->getDescription() ?>
                                    </span>
                                    <span class="font-karla-regular fs-16">-<?= number_format($orderTotals['discount_amount'], 2) ?> €</span>
                                </div>
                            <?php endif; ?>
                            
                            <hr class="border-secondary-grey">
                            
                            <div class="d-flex justify-content-between mb-4">
                                <span class="font-sting-regular fs-20 text-primary-red">Total Payment Amount</span>
                                <span class="font-sting-regular fs-24 text-primary-red" id="cart-total">
                                    <?= number_format($orderTotals['total_amount'], 2) ?> €
                                </span>
                            </div>
                            
                            <?php if ($isPending): ?>
                                <form action="?controller=Order&action=confirmOrder" method="POST" class="d-grid gap-2">
                                    <button type="submit" class="btn-red py-3 gap-3">
                                        <i data-lucide="credit-card"></i>
                                        Confirm Order
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>