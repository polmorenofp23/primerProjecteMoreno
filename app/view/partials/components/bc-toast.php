<?php

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

    function showBCNormalToast(){
        
    }