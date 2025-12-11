<header>
    <div class="main-header">
        <!-- Auth/User Links Bar -->
        <?php if (!SessionUtils::isLogged()): ?>
            <div class="auth-user-links bg-black d-flex flex-row justify-content-end align-items-center py-2">
                <a href="?controller=Auth&action=showLogin" class="btn btn-sm btn-outline-danger me-2">
                    <i class="bi bi-box-arrow-in-right"></i> SIGN IN
                </a>
                <a href="?controller=Auth&action=showRegister" class="btn btn-sm btn-danger me-2">
                    <i class="bi bi-person-plus"></i> REGISTER
                </a>
            </div>
        <?php endif; ?>
            
        <!-- Logo & Main Navbar -->
        <div class="papa d-flex flex-column justify-content-center align-items-center bg-transparent">
            <div class="bc-logo">
                <a href="?controller=Product&action=index">
                    <img src="/assets/img/logo.png" alt="Bees Cavern Website Logo" class="text-white my-3">
                </a>
            </div>
            <?php include_once VIEW_PATH . '/partials/navbar.php'; ?>
        </div>
    </div>
    <!-- Sub Navigation -->
    <div class="sub-header">
        <?php include_once VIEW_PATH . '/partials/subnavbar.php'; ?>
    </div>
</header>
<!-- <header>
    <div class="main-header">
        
        <?php if (!SessionUtils::isLogged()): ?>
        <div class="bg-black d-flex flex-row justify-content-end align-items-center py-2">
            <a href="?controller=Auth&action=showLogin" class="btn btn-sm btn-outline-danger me-2">
                <i class="bi bi-box-arrow-in-right"></i> SIGN IN
            </a>
            <a href="?controller=Auth&action=showRegister" class="btn btn-sm btn-danger me-2">
                <i class="bi bi-person-plus"></i> REGISTER
            </a>
        </div>
        <?php endif; ?>
        
        <div class="d-flex flex-column justify-content-center align-items-center bg-transparent w-100">
            <a href="?controller=Product&action=index">
                <img src="/assets/img/logo.png" alt="Bees Cavern Website Logo" class="bc-logo text-white my-3">
            </a>
            <?php //include_once VIEW_PATH . '/partials/navbar.php'; ?>
        </div>
        
        <div>
        <?php //include_once VIEW_PATH . '/partials/subnavbar.php'; ?>
        </div>

    </div>
</header> -->