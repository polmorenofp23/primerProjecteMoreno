<?php
// Determine current view section (prefix before first '/') or fallback to controller from query string.
$currentView = '';
if (isset($view) && is_string($view) && $view !== '') {
    $currentView = $view;
} elseif (isset($_GET['controller'])) {
    // fallback to controller name if view not provided
    $currentView = strtolower($_GET['controller']);
}

$currentSection = '';
if ($currentView !== '') {
    $parts = explode('/', $currentView);
    // take first part and strip extension if present
    $first = $parts[0];
    $first = strtolower(preg_replace('/\.php$/', '', $first));
    $currentSection = $first;
}

function navActive(...$names) {
    global $currentSection;
    if ($currentSection === '') return '';
    foreach ($names as $n) {
        if (strcasecmp($n, $currentSection) === 0) {
            return 'active';
        }
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
                    <a class="nav-link <?php echo navActive('home'); ?>" href="?controller=Home&action=show">HOME</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link <?php echo navActive('product'); ?>" href="?controller=Product&action=index">MENU</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link <?php echo navActive('membership'); ?>" href="?controller=Membership&action=show">MEMBERSHIP</a>
                </li>
                <?php if (SessionUtils::isAdmin()): ?>
                    <li class="nav-item mx-4">
                        <a class="nav-link <?php echo navActive('admin'); ?>" href="?controller=Auth&action=logout">ADMIN</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>