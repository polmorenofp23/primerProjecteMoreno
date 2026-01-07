<!DOCTYPE html>
<html lang="en">
<head>
    <title>Membership - Bees Cavern</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <section class="membership-hero-image w-100 p-0">
        <img src="/assets/img/extra/membership.webp" alt="Membership" class="membership-hero-img">
    </section>

    <section class="membership-hero-text py-5 dark-red-bg text-center text-white">
        <div class="container my-5">
            <h1 class="font-sting-regular fs-80 text-white text-uppercase mb-4">Become a Member<br>of Bees Cavern</h1>
            <p class="font-karla-regular fs-20 text-uppercase text-white">Unlock exclusive benefits and enjoy special discounts on all your orders</p>
        </div>
    </section>

    <section class="membership-info">
        <div class="container-fluid mx-0 px-0">
            <div class="row g-0">
                <div class="col-12 col-md-6">
                    <img src="/assets/img/extra/bc-kitchen.webp" class="membership-promo-img" alt="Membership">
                </div>

                <div class="col-12 col-md-6 bg-white d-flex flex-column justify-content-center p-5">
                    <span class="font-karla-regular fs-14 text-primary-dark-red text-uppercase mb-2">Membership Program</span>
                    <h2 class="font-sting-black fs-60 text-primary-red text-uppercase mb-4">Exclusive Benefits</h2>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <i data-lucide="check-circle" class="text-primary-red me-3 flex-shrink-0"></i>
                            <div>
                                <h5 class="font-sting-regular fs-18 text-primary-dark-red mb-1">20% Discount</h5>
                                <p class="font-karla-regular fs-14 text-secondary-grey mb-0">Get 20% off on all your orders</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <i data-lucide="check-circle" class="text-primary-red me-3 flex-shrink-0"></i>
                            <div>
                                <h5 class="font-sting-regular fs-18 text-primary-dark-red mb-1">Early Access</h5>
                                <p class="font-karla-regular fs-14 text-secondary-grey mb-0">Get notified about new products and events</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <i data-lucide="check-circle" class="text-primary-red me-3 flex-shrink-0"></i>
                            <div>
                                <h5 class="font-sting-regular fs-18 text-primary-dark-red mb-1">Priority Service</h5>
                                <p class="font-karla-regular fs-14 text-secondary-grey mb-0">Priority handling on orders and reservations</p>
                            </div>
                        </div>
                    </div>

                    <div class="white-bg border-2 border-primary-red p-4 mb-4 text-center">
                        <div class="font-sting-regular fs-48 text-primary-red mb-2 text-uppercase">Only for a monthly subscription of 25€</div>
                        <div class="font-karla-regular fs-24 text-primary-dark-red mb-4">JOIN US NOW!</div>
                        <?php if (SessionUtils::isLogged()): ?>
                            <a href="?controller=General&action=becomeMember" class="btn btn-red btn-lg text-uppercase align-self-start p-3 px-5">
                                Upgrade to Member <i data-lucide="arrow-right" class="ms-2 icon-20"></i>
                            </a>
                        <?php else: ?>
                            <a href="?controller=Auth&action=showRegister" class="btn btn-red btn-lg text-uppercase align-self-start p-3 px-5">
                                Register & Join <i data-lucide="arrow-right" class="ms-2 icon-20"></i>
                            </a>
                            <p class="font-karla-regular fs-14 text-secondary-grey mt-3">Already have an account? <a href="?controller=Auth&action=showLogin" class="text-primary-red fw-bold">Sign in</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
