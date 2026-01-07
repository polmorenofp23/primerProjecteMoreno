<!DOCTYPE html>
<html lang="en">
<head>
    <title>Membership - Bees Cavern</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <!-- Hero Section -->
    <section class="membership-hero position-relative overflow-hidden" style="height: 500px; background: linear-gradient(rgba(193, 0, 0, 0.8), rgba(193, 0, 0, 0.8)), url('/assets/img/membership-hero.jpg') center/cover;">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-12 col-md-10">
                    <h1 class="font-sting-black fs-80 text-white text-uppercase mb-4">Become a Member<br>of Bees Cavern</h1>
                    <p class="font-karla-regular fs-20 text-white">Unlock exclusive benefits and enjoy special discounts on all your orders</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Benefits Section -->
    <section class="membership-benefits py-5">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-12">
                    <h2 class="font-sting-light fs-40 text-primary-red text-uppercase mb-3">Why Join Our Membership?</h2>
                    <p class="font-karla-regular fs-18 text-secondary-grey">Experience premium benefits designed just for you</p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <!-- Benefit 1 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 bg-secondary-white h-100 text-center p-4">
                        <div class="mb-3">
                            <i data-lucide="percent" class="text-primary-red" style="width: 60px; height: 60px;"></i>
                        </div>
                        <h4 class="font-sting-regular fs-24 text-primary-dark-red mb-3">Exclusive Discount</h4>
                        <p class="font-karla-regular fs-16 text-secondary-grey">
                            <?php 
                            $discountPercentage = 15; // Default
                            if (isset($dataOut['membershipDiscount']) && $dataOut['membershipDiscount']) {
                                $discountPercentage = $dataOut['membershipDiscount']->getPercentage();
                            }
                            ?>
                            Get <?= $discountPercentage ?>% off on all your orders, every single time you visit us
                        </p>
                    </div>
                </div>

                <!-- Benefit 2 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 bg-secondary-white h-100 text-center p-4">
                        <div class="mb-3">
                            <i data-lucide="bell" class="text-primary-red" style="width: 60px; height: 60px;"></i>
                        </div>
                        <h4 class="font-sting-regular fs-24 text-primary-dark-red mb-3">Early Access</h4>
                        <p class="font-karla-regular fs-16 text-secondary-grey">Be the first to know about new menu items and seasonal specials</p>
                    </div>
                </div>

                <!-- Benefit 3 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 bg-secondary-white h-100 text-center p-4">
                        <div class="mb-3">
                            <i data-lucide="gift" class="text-primary-red" style="width: 60px; height: 60px;"></i>
                        </div>
                        <h4 class="font-sting-regular fs-24 text-primary-dark-red mb-3">Birthday Treats</h4>
                        <p class="font-karla-regular fs-16 text-secondary-grey">Celebrate your special day with a complimentary dessert on us</p>
                    </div>
                </div>

                <!-- Benefit 4 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 bg-secondary-white h-100 text-center p-4">
                        <div class="mb-3">
                            <i data-lucide="star" class="text-primary-red" style="width: 60px; height: 60px;"></i>
                        </div>
                        <h4 class="font-sting-regular fs-24 text-primary-dark-red mb-3">Priority Service</h4>
                        <p class="font-karla-regular fs-16 text-secondary-grey">Enjoy priority handling on your orders and reservations</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Details Section -->
    <section class="membership-details py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <!-- Image Column -->
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                    <img src="/assets/img/membership-card.jpg" 
                         alt="Membership Card" 
                         class="img-fluid rounded shadow"
                         style="max-height: 500px; width: 100%; object-fit: cover;">
                </div>

                <!-- Details Column -->
                <div class="col-12 col-lg-6">
                    <div class="ps-lg-5">
                        <h2 class="font-sting-light fs-40 text-primary-red text-uppercase mb-4">Membership Details</h2>
                        
                        <?php if (isset($dataOut['membershipDiscount']) && $dataOut['membershipDiscount']): ?>
                            <div class="mb-4">
                                <h4 class="font-sting-regular fs-28 text-primary-dark-red mb-2">
                                    <?= htmlspecialchars($dataOut['membershipDiscount']->getName()) ?>
                                </h4>
                                <?php if ($dataOut['membershipDiscount']->getDescription()): ?>
                                    <p class="font-karla-regular fs-16 text-secondary-grey">
                                        <?= htmlspecialchars($dataOut['membershipDiscount']->getDescription()) ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="card border-primary-red mb-4" style="border-width: 2px;">
                                <div class="card-body text-center py-4">
                                    <div class="font-sting-black fs-60 text-primary-red">
                                        <?= $dataOut['membershipDiscount']->getPercentage() ?>%
                                    </div>
                                    <div class="font-karla-regular fs-18 text-primary-dark-red">
                                        Discount on All Orders
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <p class="font-karla-regular fs-16 mb-0">Membership benefits information will be available soon.</p>
                            </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <h5 class="font-sting-regular fs-20 text-primary-dark-red mb-3">What's Included:</h5>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-2">
                                    <i data-lucide="check-circle" class="text-success me-2 flex-shrink-0" style="width: 20px; height: 20px;"></i>
                                    <span class="font-karla-regular fs-16 text-secondary-grey">Lifetime membership with no expiration date</span>
                                </li>
                                <li class="d-flex align-items-start mb-2">
                                    <i data-lucide="check-circle" class="text-success me-2 flex-shrink-0" style="width: 20px; height: 20px;"></i>
                                    <span class="font-karla-regular fs-16 text-secondary-grey">Automatic discount applied at checkout</span>
                                </li>
                                <li class="d-flex align-items-start mb-2">
                                    <i data-lucide="check-circle" class="text-success me-2 flex-shrink-0" style="width: 20px; height: 20px;"></i>
                                    <span class="font-karla-regular fs-16 text-secondary-grey">Access to members-only events and promotions</span>
                                </li>
                                <li class="d-flex align-items-start mb-2">
                                    <i data-lucide="check-circle" class="text-success me-2 flex-shrink-0" style="width: 20px; height: 20px;"></i>
                                    <span class="font-karla-regular fs-16 text-secondary-grey">Monthly newsletter with exclusive recipes and tips</span>
                                </li>
                            </ul>
                        </div>

                        <?php if (SessionUtils::isLogged()): ?>
                            <a href="?controller=User&action=profile" class="btn btn-danger btn-lg w-100 text-uppercase">
                                Upgrade to Membership →
                            </a>
                        <?php else: ?>
                            <a href="?controller=Auth&action=showRegister" class="btn btn-danger btn-lg w-100 text-uppercase mb-2">
                                Register & Join Now →
                            </a>
                            <p class="text-center font-karla-regular fs-14 text-secondary-grey mb-0">
                                Already have an account? <a href="?controller=Auth&action=showLogin" class="text-primary-red">Sign in</a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works py-5 bg-secondary-white">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-12">
                    <h2 class="font-sting-light fs-40 text-primary-red text-uppercase mb-3">How It Works</h2>
                    <p class="font-karla-regular fs-18 text-secondary-grey">Join our membership in three easy steps</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Step 1 -->
                <div class="col-12 col-md-4">
                    <div class="text-center">
                        <div class="bg-primary-red rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <span class="font-sting-black fs-32 text-white">1</span>
                        </div>
                        <h4 class="font-sting-regular fs-24 text-primary-dark-red mb-3">Create Account</h4>
                        <p class="font-karla-regular fs-16 text-secondary-grey">Sign up for a free account on our website in just a few clicks</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-12 col-md-4">
                    <div class="text-center">
                        <div class="bg-primary-red rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <span class="font-sting-black fs-32 text-white">2</span>
                        </div>
                        <h4 class="font-sting-regular fs-24 text-primary-dark-red mb-3">Choose Membership</h4>
                        <p class="font-karla-regular fs-16 text-secondary-grey">Select the membership tier that best fits your needs</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-12 col-md-4">
                    <div class="text-center">
                        <div class="bg-primary-red rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <span class="font-sting-black fs-32 text-white">3</span>
                        </div>
                        <h4 class="font-sting-regular fs-24 text-primary-dark-red mb-3">Start Saving</h4>
                        <p class="font-karla-regular fs-16 text-secondary-grey">Enjoy your exclusive discounts and benefits immediately</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials py-5 bg-white">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-12">
                    <h2 class="font-sting-light fs-40 text-primary-red text-uppercase mb-3">What Our Members Say</h2>
                </div>
            </div>

            <div class="row g-4">
                <!-- Testimonial 1 -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 bg-secondary-white h-100 p-4">
                        <div class="mb-3">
                            <div class="text-warning">★★★★★</div>
                        </div>
                        <p class="font-karla-regular fs-16 text-secondary-grey mb-3">"The membership discount has been amazing! I eat here regularly and the savings really add up. Plus, the priority service is fantastic."</p>
                        <div class="mt-auto">
                            <strong class="font-sting-regular fs-18 text-primary-dark-red">Sarah M.</strong>
                            <div class="font-karla-regular fs-14 text-secondary-grey">Member since 2024</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 bg-secondary-white h-100 p-4">
                        <div class="mb-3">
                            <div class="text-warning">★★★★★</div>
                        </div>
                        <p class="font-karla-regular fs-16 text-secondary-grey mb-3">"Best decision ever! The early access to new menu items means I always get to try the latest creations before anyone else."</p>
                        <div class="mt-auto">
                            <strong class="font-sting-regular fs-18 text-primary-dark-red">James T.</strong>
                            <div class="font-karla-regular fs-14 text-secondary-grey">Member since 2023</div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 bg-secondary-white h-100 p-4">
                        <div class="mb-3">
                            <div class="text-warning">★★★★★</div>
                        </div>
                        <p class="font-karla-regular fs-16 text-secondary-grey mb-3">"Love the birthday treats and exclusive events. It's more than just a discount - it's a whole experience!"</p>
                        <div class="mt-auto">
                            <strong class="font-sting-regular fs-18 text-primary-dark-red">Emma L.</strong>
                            <div class="font-karla-regular fs-14 text-secondary-grey">Member since 2024</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5 bg-primary-dark-red text-white text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <h2 class="font-sting-black fs-60 text-white text-uppercase mb-3">Ready to Join?</h2>
                    <p class="font-karla-regular fs-18 text-white mb-4">Start enjoying exclusive benefits and savings today</p>
                    <?php if (SessionUtils::isLogged()): ?>
                        <a href="?controller=User&action=profile" class="btn btn-light btn-lg text-uppercase px-5">Upgrade Now →</a>
                    <?php else: ?>
                        <a href="?controller=Auth&action=showRegister" class="btn btn-light btn-lg text-uppercase px-5">Join Now →</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
