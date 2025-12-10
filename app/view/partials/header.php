<header>
    <div class="main-header">
        <!-- Auth/User Links Bar -->
        <?php if (!SessionUtils::isLogged()): ?>
        <div class="bg-black d-flex flex-row justify-content-end align-items-center py-2">
            <a href="?controller=Auth&action=showLogin" class="btn btn-sm btn-outline-danger me-2">
                <i class="bi bi-box-arrow-in-right"></i> SIGN IN
            </a>
            <a href="?controller=Auth&action=showRegister" class="btn btn-sm btn-danger">
                <i class="bi bi-person-plus"></i> REGISTER
            </a>
        </div>
        <?php endif; ?>
        <!-- Logo & Main Navbar -->
        <div class="d-flex flex-column justify-content-center align-items-center w-100">
            <a href="?controller=Product&action=index">
                <img src="/assets/img/logo.png" alt="Bees Cavern Website Logo" class="bc-logo text-white my-3">
            </a>
            <?php include_once VIEW_PATH . '/partials/navbar.php'; ?>
        </div>
        
        <!-- Sub Navigation -->
        <div>
        <?php include_once VIEW_PATH . '/partials/subnavbar.php'; ?>
        </div>
    </div>
</header>