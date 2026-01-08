<header>
    <div class="<?php if ($viewSection == 'home'): ?> home-header <?php else: ?> main-header <?php endif; ?>">
        <?php if (!SessionUtils::isLogged()): ?>
            <div class="auth-user-links bg-black d-flex flex-row justify-content-end align-items-center py-2 z-1">
                <a href="?controller=Auth&action=showLogin" class="me-2">SIGN IN</a>
                <a class="text-white me-2">|</a>
                <a href="?controller=Auth&action=showRegister" class="me-2">REGISTER</a>
            </div>
        <?php endif; ?>
            
        <div class="main-navbar-box d-flex flex-column justify-content-center align-items-center bg-transparent z-3">
            <div class="bc-logo">
                <a href="?controller=General&action=home">
                    <img src="/assets/img/logos/logo-bc-official.svg" alt="Bees Cavern Website Logo" class="text-white mt-3">
                </a>
            </div>
            <?php include_once VIEW_PATH . '/partials/navbar.php'; ?>
        </div>
    </div>
    <?php if ($viewSection !== 'home' && $viewSection !== 'membership' && $viewSection !== 'admin' && $viewSection !== 'errors'): ?>
        <div class="sub-header">
            <?php include_once VIEW_PATH . '/partials/subnavbar.php'; ?>
        </div>
    <?php endif; ?>
</header>