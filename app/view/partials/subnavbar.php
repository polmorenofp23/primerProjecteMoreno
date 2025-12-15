<nav class="sub-navbar navbar navbar-expand-lg navbar-dark bg-black">
    <div class="container-fluid justify-content-center align-items-center">

        <!-- Toggler + nav items (collapse for small screens) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#subNavbar"
            aria-controls="subNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse d-flex flex-row justify-content-between py-0" id="subNavbar">

            <!-- Left-aligned nav items -->
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
                        <a class="nav-link" href="?controller=Product&action=index">Drinks</a>
                    </li>
                </ul>
            <?php endif; ?>

            <!-- Right-aligned nav items -->
            <?php if ($viewSection === 'user'): ?>
                <ul class="navbar-nav">
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="?controller=Auth&action=logout"><i data-lucide="log-out" class="icon-white"></i></a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="?controller=User&action=showFavouriteProducts">
                            <i data-lucide="heart" class="icon-white"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php if (SessionUtils::isLogged()): ?>
                            <!--<a class="nav-link mx-2 dropdown-toggle" href="?controller=User&action=edit" id="userMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-lucide="circle-user-round" class="icon-white"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="userMenuDropdown">
                                <?php //$fullName = trim($logUser->getFirstName() . ' ' . ($logUser->getLastName() ?? '')); ?>
                                <li>
                                    <h5 class="dropdown-header text-center"><?php //echo htmlspecialchars($fullName); ?></h5>
                                </li>
                                <li><hr class="dropdown-divider bg-white"></li>
                                <li><a class="dropdown-item" href="?controller=User&action=showFavouriteProducts"><i data-lucide="heart" class="icon-white mx-2"></i>Favourite Products</a></li>
                                <li><a class="dropdown-item" href="?controller=User&action=showOrderHistory"><i data-lucide="clipboard-clock" class="icon-white mx-2"></i>Order History</a></li>
                                <li><a class="dropdown-item" href="?controller=User&action=edit"><i data-lucide="circle-user-round" class="icon-white mx-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider bg-white"></li>
                                <li><a class="dropdown-item" href="?controller=Auth&action=logout"><i data-lucide="log-out" class="icon-white mx-2"></i>Logout</a></li>
                            </ul>-->
                            <div class="btn-group p-0">
                                <button type="button" class="btn p-0"><a class="nav-link btn btn-link" href="?controller=User&action=edit" role="button" aria-label="Profile">
                                        <i data-lucide="circle-user-round" class="icon-white"></i>
                                    </a></button>
                                <button type="button" class="btn dropdown-toggle dropdown-toggle-split p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="userMenuDropdown">
                                    <?php $fullName = trim($logUser->getFirstName() . ' ' . ($logUser->getLastName() ?? '')); ?>
                                    <li>
                                        <h5 class="dropdown-header text-center"><?php echo htmlspecialchars($fullName); ?></h5>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider bg-white">
                                    </li>
                                    <li><a class="dropdown-item" href="?controller=User&action=showFavouriteProducts"><i data-lucide="heart" class="icon-white mx-2"></i>Favourite Products</a></li>
                                    <li><a class="dropdown-item" href="?controller=User&action=showOrderHistory"><i data-lucide="clipboard-clock" class="icon-white mx-2"></i>Order History</a></li>
                                    <li><a class="dropdown-item" href="?controller=User&action=edit"><i data-lucide="circle-user-round" class="icon-white mx-2"></i>Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider bg-white">
                                    </li>
                                    <li><a class="dropdown-item" href="?controller=Auth&action=logout"><i data-lucide="log-out" class="icon-white mx-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a class="nav-link mx-2" href="?controller=Auth&action=showLogin">
                                <i data-lucide="circle-user-round" class="icon-white"></i>
                            </a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="?controller=Product&action=index">
                            <i data-lucide="shopping-cart" class="icon-white"></i>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>