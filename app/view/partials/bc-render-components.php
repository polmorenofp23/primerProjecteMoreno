<?php

    
require_once DAO_PATH . 'ProductRatingDAO.php';

    function showHttpResponseToast(?\HttpResponse $response = null, string $bgClass = '', string $textClass = '', int $delay = 3000) {
        if (!$response) return;
        $code = $response->getCode();
        $name = $response->getName();
        $description = $response->getDescription();
        $level = $response->getLevel();
        $msg = $response->getMessage();
        $title = $response->getTitle();
        $toastId = 'bcToast' . uniqid();

        $stylesDefByParams = ($bgClass !== '' || $textClass !== '');
        if ($bgClass === '') $bgClass = 'bg-light';
        if ($textClass === '') $textClass = 'text-dark';

        if (!$stylesDefByParams) {
            switch ($level) {
                case 'success': $bgClass = 'bg-success text-white'; $textClass = 'text-white'; break;
                case 'info': $bgClass = 'bg-info text-white'; $textClass = 'text-white'; break;
                case 'warning': $bgClass = 'bg-warning text-dark'; $textClass = 'text-dark'; break;
                case 'danger': $bgClass = 'bg-danger text-white'; $textClass = 'text-white'; break;
            }
        }

        ?>
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
            <div id="<?php echo $toastId; ?>" class="toast align-items-center <?php echo $bgClass; ?> border-0" role="alert" 
                data-bs-delay="<?php echo (int)$delay; ?>" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body <?php echo $textClass; ?>">
                        <?php if ($msg !== null && $msg !== '') { ?> <!-- "title: msg" -->
                            <strong><?php echo htmlspecialchars((string)$title); ?>:</strong>
                            <span> <?php echo htmlspecialchars((string)$msg); ?></span>
                        <?php } else { ?>  <!-- "title code: name" & netx line description -->
                            <strong><?php echo htmlspecialchars((string)$title); ?> <?php echo htmlspecialchars((string)$code); ?>: <?php echo htmlspecialchars((string)$name); ?></strong>
                            <div><?php echo htmlspecialchars((string)$description); ?></div>
                        <?php } ?>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <?php
    }

    function renderBCPageTitle(array $breadcrumbs = []){
        $items = [];    
        if (!empty($breadcrumbs)) { // Normalize to list of ['label'=>..,'url'=>..]
            $first = reset($breadcrumbs);
            if (is_array($first) && array_key_exists('label', $first)) {
                foreach ($breadcrumbs as $it) {
                    $items[] = ['label' => (string)($it['label'] ?? ''), 'url' => $it['url'] ?? null];
                }
            } else {
                foreach ($breadcrumbs as $label => $url) {
                    $items[] = ['label' => (string)$label, 'url' => $url ?? null];
                }
            }
        }

        $title = '';
        $activeIndex = null;
        foreach ($items as $idx => $it) {
            if ($it['url'] === null || $it['url'] === '') { $title = $it['label']; $activeIndex = $idx; break; }
        }
        if ($activeIndex === null && !empty($items)) {
            $last = end($items);
            $title = $last['label'];
            $activeIndex = count($items) - 1;
        }

        ?>
        <div class="bc-page-title w-100 py-3">
            <?php if (!empty($items)) : ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent font-sting-light fs-12 ms-5 mb-2">
                        <?php foreach ($items as $i => $it):
                            $labelEsc = htmlspecialchars((string)$it['label']);
                            $urlStr = $it['url'] === null ? '' : (string)$it['url'];
                            $isActive = ($i === $activeIndex || $urlStr === '');
                        ?>
                            <?php if ($isActive): ?>
                                <li class="breadcrumb-item text-primary-grey active" aria-current="page"><?php echo $labelEsc; ?></li>
                            <?php else: ?>
                                <li class="breadcrumb-item"><a href="<?php echo htmlspecialchars($urlStr); ?>"><?php echo $labelEsc; ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            <?php endif; ?>

            <?php if ($title !== ''): ?>
                <div class="row align-items-center">
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <hr class="col-1 border-0 bg-primary-red py-1">
                            <h1 class="font-sting-regular fs-48 text-primary-dark-red ms-4"><?php echo htmlspecialchars($title); ?></h1>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php
    }

    function renderBCProductCard(Product $product) {
        $id = $product->getId() ?? null;
        $name = $product->getName() ?? '';
        $price = is_numeric($product->getPrice() ?? null) ? (float)$product->getPrice() : 0.0;
        $dishType = $product->getDishType() ?? '';
        $imgDir = $product->getImgDir();

        $defaultImg = '/assets/img/products/default.webp';
        $imgSrc = $defaultImg;

        if (is_array($imgDir) && !empty($imgDir['A'])) {
            $candidate = (string)$imgDir['A'];
            $fsPath = rtrim((string)$_SERVER['DOCUMENT_ROOT'], "\\/") . '/' . ltrim($candidate, '/');
            if (file_exists($fsPath)) {
                $imgSrc = '/' . ltrim($candidate, '/');
            }
        }

        $rating = null; 
        try {
            $prdao = new ProductRatingDAO();
            $avg = $prdao->getProductRatingAverage((int)$id);
            if ($avg !== null) $rating = (float)$avg;
        } catch (Exception $e) {
            $rating = null;
        } 
        if ($rating === null) $rating = 0.0;

        ?>
        <div class="card bc-menu-product-card h-100 w-100 border-0 rounded-0 shadow-none">
            <a href="?controller=Product&action=show&id=<?php echo htmlspecialchars((string)$id); ?>" class="text-decoration-none text-reset">
                <div class="ratio ratio-1x1">
                    <img src="<?php echo htmlspecialchars($imgSrc); ?>" 
                        alt="<?php echo htmlspecialchars($name); ?>" class="card-img-top object-fit-cover w-100 h-100 rounded-1 border-1">
                </div>
                <div class="card-body d-flex flex-column justify-content-between py-2">
                    <div class="mb-2">
                        <h6 class="card-title font-sting-light fs-14 text-truncate mb-1" title="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></h6>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <?php if ($dishType !== ''): ?>
                                <small class="text-muted font-karla-regular text-uppercase"><?php echo htmlspecialchars($dishType); ?></small>
                            <?php endif; ?>
                            <button type="button" class="btn btn-transparent p-0" id="openEditProductModal" aria-label="Open edit product modal" data-product-id="<?php echo htmlspecialchars((string)$id); ?>">
                                <i data-lucide="eye" class="icon-black"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="text-start font-sting-regular"><?php echo htmlspecialchars(number_format($price, 2)); ?>€</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="stars" aria-hidden="true">
                                    <?php
                                        $rounded = (int)round($rating);
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rounded) {
                                                echo '<span class="text-primary-red">&#9733;</span>'; // filled star
                                            } else {
                                                echo '<span class="text-primary-red">&#9734;</span>'; // empty star
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <small class="text-primary-red font-sting-light ms-2"><?php echo htmlspecialchars(number_format($rating, 1)); ?>/5</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
    }