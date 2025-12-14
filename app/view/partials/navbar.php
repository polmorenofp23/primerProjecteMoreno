<?php
function navActiveSection($name, $sectionName) { 
    if ($name === $sectionName) {   
        return 'active';
    }
    return '';
}

?>
<nav class="main-navbar navbar navbar-expand-lg navbar-dark bg-transparent">
    <div class="container-fluid justify-content-center align-items-center">

        <!-- Toggler + nav items (collapse for small screens) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ">
                <li class="nav-item mx-4">
                    <a class="nav-link <?php echo navActiveSection('home', $viewSection); ?>" href="?controller=Home&action=show">HOME</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link <?php echo navActiveSection('product', $viewSection); ?>" href="?controller=Product&action=index">MENU</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link <?php echo navActiveSection('membership', $viewSection); ?>" href="?controller=Membership&action=show">MEMBERSHIP</a>
                </li>
                <?php if (SessionUtils::isAdmin()): ?>
                    <li class="nav-item mx-4">
                        <a class="nav-link <?php echo navActiveSection('admin', $viewSection); ?>" href="?controller=Admin&action=index">ADMIN</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>