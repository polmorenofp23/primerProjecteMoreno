<nav class="sub-navbar navbar navbar-expand-lg navbar-dark bg-black ">
    <div class="container-fluid justify-content-center align-items-center">

        <!-- Toggler + nav items (collapse for small screens) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#subNavbar"
            aria-controls="subNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse py-0" id="subNavbar">
            
            <?php if (strpos($view, 'product') === 0): ?>
                <ul class="navbar-nav ">
                    <li class="nav-item mx-4">
                        <a class="nav-link active" href="?controller=Product&action=index">Appetissers</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=Product&action=index">Main Plates</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=Product&action=index">Desserts</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=Auth&action=logout">Drinks</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>

