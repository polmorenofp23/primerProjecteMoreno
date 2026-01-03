<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order History - Bees Cavern</title>
    <link rel="stylesheet" href="/css/products-styles.css">
</head>
<body>
    <div class="d-flex flex-column justify-content-center align-items-center col-12">
        <div class="d-flex flex-column justify-content-between align-items-center col-12 my-4">
            <div class="w-100">
                <?php
                    renderBCPageTitle(['Order History' => null]);
                ?>
            </div>
        </div>

        <?php if (empty($orders)): ?>
            <div class="row my-5">
                <div class="col-12 text-center">
                    <i data-lucide="history" class="icon-64 icon-grey mb-4"></i>
                    <h3 class="font-sting-light fs-32 text-primary-grey mb-4">No orders yet</h3>
                    <a href="?controller=Product&action=index" class="btn-red px-5 py-3 my-5">Start Ordering</a>
                </div>
            </div>
        <?php else: ?>
            <div class="col-11 col-lg-10 my-4">
                <div class="order-history-container mb-5">
                    <table class="table w-100 font-karla-regular fs-16 text-primary-black">
                        <thead class="font-sting-light">
                            <tr>
                                <th class="text-start align-middle">Order ID</th>
                                <th class="text-center align-middle">Date</th>
                                <th class="text-center align-middle">Hour</th>
                                <th class="text-center align-middle">Status</th>
                                <th class="text-center align-middle">Payment</th>
                                <th class="text-center align-middle">Table</th>
                                <th class="text-end align-middle">Discount</th>
                                <th class="text-end align-middle">Total</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <?php
                                    $createdAt = $order->getCreatedAt();
                                    $formattedDate = '';
                                    $formattedHour = '';
                                    if ($createdAt) {
                                        $dateObj = new DateTime($createdAt);
                                        $formattedDate = $dateObj->format('d/m/Y');
                                        $formattedHour = $dateObj->format('H:i');
                                    }
                                    $orderStatus = $order->getOrderStatus();
                                    $paymentStatus = $order->getPaymentStatus();
                                ?>
                                <tr>
                                    <td class="align-middle text-start">
                                        <span class="font-sting-regular">#<?= htmlspecialchars($order->getId()) ?></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class=""><?= $formattedDate ?></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class=""><?= $formattedHour ?></span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="font-sting-regular text-uppercase fs-14">
                                            <?= htmlspecialchars(str_replace('-', ' ', $orderStatus)) ?>
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="font-sting-regular text-uppercase fs-14">
                                            <?= htmlspecialchars(str_replace('-', ' ', $paymentStatus)) ?>
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="">
                                            <?= $order->getTableId() ? htmlspecialchars($order->getTableId()) : '-' ?>
                                        </span>
                                    </td>
                                    <td class="align-middle text-end">
                                        <span class="<?= $order->getDiscountAmount() > 0 ? 'text-success' : '' ?>">
                                            <?= $order->getDiscountAmount() > 0 ? '-' : '' ?><?= number_format($order->getDiscountAmount(), 2) ?> €
                                        </span>
                                    </td>
                                    <td class="align-middle text-end">
                                        <span class="">
                                           <?= number_format($order->getTotalAmount(), 2) ?> €
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="?controller=Order&action=show&id=<?= $order->getId() ?>" 
                                           class="btn btn-sm bg-transparent border-0 p-2">
                                            <i data-lucide="eye" class="icon-grey"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
