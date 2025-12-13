<nav class="sub-navbar navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container-fluid justify-content-center align-items-center">

        <!-- Toggler + nav items (collapse for small screens) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#subNavbar"
            aria-controls="subNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-flex flex-row justify-content-between py-0" id="subNavbar">

            <?php if ($viewSection === 'admin'): ?>
                <ul class="navbar-nav">
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=Admin&action=index">Orders</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=Admin&action=index">Products</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=Admin&action=index">Ingredients</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=Admin&action=index">Offers</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=Admin&action=index">Logs</a>
                    </li>
                </ul>
            <?php elseif ($viewSection === 'user'): ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link mx-4" href="?controller=User&action=index">Favourite Products</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=User&action=index">Order Historial</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=User&action=edit">Profile</a>
                    </li>
                </ul>
            <?php else: ?>
                <!--<div class=" w-100">-->
                    <ul class="navbar-nav">
                        <li class="nav-item mx-4">
                            <a class="nav-link" href="?controller=Product&action=index">Appetissers</a>
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
                    <ul class="display-end navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="?controller=Product&action=index">
                                <i data-lucide="heart" class="icon-white"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="?controller=User&action=edit">
                                <i data-lucide="circle-user-round" class="icon-white"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-2" href="?controller=Product&action=index">
                                <i data-lucide="shopping-cart" class="icon-white"></i>
                            </a>
                        </li>
                    </ul>

                <!--</div>-->
            <?php endif; ?>
        </div>
    </div>
</nav>