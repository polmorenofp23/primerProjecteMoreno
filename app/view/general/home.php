<?php require_once VIEW_PATH . 'partials/bc-render-components.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - Bees Cavern</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <section class="hero-section position-relative overflow-hidden w-100">
        <div class="hero-carousel-wrapper w-100 bg-primary-dark-red">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner w-100">
                    <div class="carousel-item active">
                        <img src="/assets/img/extra/bc-home-1.webp" class="d-block hero-carousel-img" alt="Bees Cavern - Experience">
                        <div class="carousel-caption d-none d-md-block position-absolute end-0 bottom-0 top-50 translate-middle-y w-auto pe-5 me-5 text-end">
                            <h1 class="font-sting-regular fs-80 text-white text-uppercase mb-4">Premium<br>Quality<br>Experience</h1>
                            <p class="font-karla-regular fs-16 text-white text-uppercase">Discover the finest selection of our cuisine</p>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="/assets/img/extra/bc-home-3.webp" class="d-block hero-carousel-img" alt="Bees Cavern - First Team Visit">
                        <div class="carousel-caption d-none d-md-block position-absolute end-0 bottom-0 top-50 translate-middle-y w-auto pe-5 me-5 text-end">
                            <h1 class="font-sting-regular fs-80 text-white text-uppercase mb-4">First Team<br>Came to Visit<br>Our Cavern</h1>
                            <p class="font-karla-regular fs-16 text-white text-uppercase">Discover the finest selection of our cuisine</p>
                        </div>
                    </div>                    

                    <div class="carousel-item">
                        <img src="/assets/img/extra/bc-home-4.webp" class="d-block hero-carousel-img" alt="Bees Cavern - Membership">
                        <div class="carousel-caption d-none d-md-block position-absolute end-0 bottom-0 top-50 translate-middle-y w-auto pe-5 me-5 text-end">
                            <h1 class="font-sting-regular fs-80 text-white text-uppercase mb-4">Join Our<br>Membership<br>Program</h1>
                            <a href="?controller=General&action=membership" class="btn btn-red btn-lg mt-4 text-uppercase rounded-0">
                                Learn More <i data-lucide="arrow-right" class="ms-2 icon-20"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev h-75 mt-5" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next h-75 mt-5" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <div class="white-bg">
        <section class="newest-products-section d-flex flex-column justify-content-center align-items-center py-5">
            <?php renderBCPageTitle(['Newest Products' => null], false); ?>
            <div class="col-11">
                <?php if (isset($newestProducts) && !empty($newestProducts)): ?>
                    <?php renderBCProductsCarousel($newestProducts, 'newestCarousel'); ?>
                <?php endif; ?>
            </div>
        </section>

        <section class="filter-products-section py-5">
            <?php renderBCPageTitle(['Filter Products' => null], false); ?>
            <div class="d-flex flex-column justify-content-center align-items-center mb-5">
                <div class="col-11 row g-4">
                    <?php 
                    $categories = [
                        ['name' => 'Appetisers', 'value' => 'appetiser', 'img' => '/assets/img/categories/appetisers.webp'],
                        ['name' => 'Main Plates', 'value' => 'main', 'img' => '/assets/img/categories/main-plates.webp'],
                        ['name' => 'Desserts', 'value' => 'dessert', 'img' => '/assets/img/categories/desserts.webp'],
                        ['name' => 'Drinks', 'value' => 'drink', 'img' => '/assets/img/categories/drinks.webp']
                    ];
                    
                    foreach ($categories as $category): 
                    ?>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <a href="?controller=Product&action=index&dish_type=<?= $category['value'] ?>" class="text-decoration-none">
                                <div class="card bg-dark text-white border-0 rounded-0 h-100 position-relative overflow-hidden shadow-sm transition category-filter-card">
                                    <img src="<?= $category['img'] ?>" class="card-img h-100 img-fluid category-filter-img" alt="<?= $category['name'] ?>">
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </div>

    <section class="promotional-section">
        <div class="container-fluid mx-0 px-0">
            <div class="row g-0">
                <div class="col-12 col-md-6">
                    <img src="/assets/img/extra/offer-halloween.webp" class="promo-offer-img" alt="Halloween Promo">
                </div>
                <div class="col-12 col-md-6 d-flex flex-column justify-content-center p-5">
                    <span class="font-karla-regular fs-14 text-primary-dark-red text-uppercase">Halloween Promo 2025/26</span>
                    <h3 class="font-sting-black fs-60 text-primary-red text-uppercase mt-3">Welcome Pumpkins:<br>Only 31/10, Every Product That Contains Pumpkin Would Have 31% Discount</h3>
                    <a href="?controller=Product&action=index" class="btn btn-red mt-4 p-3 align-self-start text-uppercase w-25">
                        ORDER NOW <i data-lucide="arrow-right" class="ms-2 icon-20"></i>
                    </a>
                </div>
            </div>

            <div class="row g-0">
                <div class="col-12 col-md-6 order-md-2">
                    <img src="/assets/img/extra/offer-christmas.webp" class="promo-offer-img" alt="Christmas Promo">
                </div>
                <div class="col-12 col-md-6 order-md-1 d-flex flex-column justify-content-center p-5">
                    <span class="font-karla-regular fs-14 text-primary-dark-red text-uppercase">Christmas Special 2025/26</span>
                    <h3 class="font-sting-black fs-60 text-primary-red text-uppercase mt-3">Premium Beef Entrecot:<br>1kg Steak For All Meat Lovers</h3>
                    <a href="?controller=Product&action=index" class="btn btn-red mt-4 p-3 align-self-start text-uppercase w-25">
                        Discover <i data-lucide="arrow-right" class="ms-2 icon-20"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="dark-red-2-bg d-flex flex-column justify-content-center align-items-center text-white text-center py-5">
            <div class="col-11 row justify-content-center">
                <div class="col-12 col-md-8 my-5">
                    <h2 class="font-sting-regular fs-60 text-white text-uppercase mb-3">Don't Miss The Opportunity To Be "Membership" Of Bees Cavern</h2>
                    <p class="font-karla-regular fs-18 text-white text-uppercase mb-4">GET A 20% DISCOUNT OF ALL your orders and Get notified ON NEWEST PRODUCTS, EVENTS and the latest offers</p>
                    <a href="?controller=General&action=membership" class="btn btn-light btn-lg text-uppercase px-5 mt-5 rounded-0">
                        GET MORE INFO <i data-lucide="arrow-right" class="ms-2 icon-red icon-20"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="best-sellers-section bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <?php renderBCPageTitle(['Best Sellers' => null], false); ?>
        <div class="col-11">
            <?php if (isset($topRatedProducts) && !empty($topRatedProducts)): ?>
                <?php renderBCProductsCarousel($topRatedProducts, 'bestSellersCarousel'); ?>
            <?php else: ?>
                <p class="font-karla-regular fs-20 text-primary-dark-red text-uppercase text-center">No top rated products available at the moment. Please check back later!</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
