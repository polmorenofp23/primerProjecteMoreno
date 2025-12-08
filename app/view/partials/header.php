<header>
    <!-- Auth/User Links Bar -->
    <div class="bg-light border-bottom py-2">
        <div class="container-fluid">
            <div class="d-flex justify-content-end align-items-center">
                <?php
                // Check if user is logged in
                // $isLoggedIn = false;
                // if (class_exists('Session')) {
                //     Session::start();
                //     $isLoggedIn = Session::isLoggedIn();
                // }
                ?>

                <?php if (!$isLoggedIn): ?>
                    <a href="?controller=Auth&action=showLogin" class="btn btn-sm btn-outline-primary me-2">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a href="?controller=Auth&action=showRegister" class="btn btn-sm btn-primary">
                        <i class="bi bi-person-plus"></i> Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div>
        <?php include_once VIEW_PATH . '/partials/navbar.php'; ?>
    </div>

    <!-- Sub Navigation -->
    <div>
    <?php include_once VIEW_PATH . '/partials/subnavbar.php'; ?>
    </div>
</header>