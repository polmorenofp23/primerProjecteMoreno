<link rel="stylesheet" href="/css/auth-styles.css">
<div class="container-fluid register-page auth-bg">

    <?php include_once VIEW_PATH . '/partials/auth-header.php'; ?>

    <div class="container-fluid d-flex align-items-center justify-content-center">
        <div class="form-card d-flex flex-column justify-content-center align-items-center bg-white p-5 col-md-8 col-lg-6 my-5">
            <div class="card-header">
                <h2 class="auth-form-title">REGISTER</h2>
            </div>

            <!-- Register Form -->
            <div class="card-body px-5 pt-3 w-100">
                <form method="POST" action="?controller=Auth&action=doRegister" class="d-flex flex-column" novalidate>
                    <legend class="form-label">User Identifier</legend>
                    <!-- First Name -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" id="firstname" name="first_name"
                                placeholder="First name" required>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" id="lastname" name="last_name"
                                placeholder="Last name">
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" id="username" name="username"
                                placeholder="Username" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group d-flex flex-column justify-content-center">
                            <input type="email" class="form-control w-100 p-3" id="email" name="email"
                                placeholder="Email" required>
                        </div>
                    </div>

                     <!-- Phone -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group">
                            <input type="tel" class="form-control p-3" id="phone" name="phone"
                                placeholder="Phone number">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-password">
                            <input type="password" class="form-control p-3" id="password" name="password"
                                placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" id="togglePasswordBtn" aria-label="Toggle password visibility">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-password">
                            <input type="password" class="form-control p-3" id="password_confirm" name="password_confirm"
                                placeholder="Confirm your password" required>
                            <button type="button" class="password-toggle" id="togglePasswordConfirmBtn" aria-label="Toggle password confirmation visibility">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Date of Birth -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <legend class="form-label">Date of Birth</legend>
                        <div class="input-group row g-2">
                            <div class="col-4">
                                <input type="number" class="form-control p-3" name="birth_day"
                                    placeholder="DD" min="1" max="31">
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control p-3" name="birth_month"
                                    placeholder="MM" min="1" max="12">
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control p-3" name="birth_year"
                                    placeholder="YYYY" min="1900" max="2026">
                            </div>
                            <!--<input type="date" class="form-control p-3" name="birth_date" id="birth_date"
                                placeholder="YYYY-MM-DD">-->
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <legend class="form-label">Address</legend>
                        <div class="input-group">
                            <input type="text" class="form-control p-3 mb-2" id="street" name="address_street"
                                placeholder="Street">
                            <div class="d-flex g-2">
                                <input type="text" class="form-control p-3 me-2" id="city" name="address_city"
                                    placeholder="City">
                                <input type="text" class="form-control p-3 me-2" id="postcode" name="address_postcode"
                                    placeholder="Postcode">
                                <input type="text" class="form-control p-3" id="country" name="address_country"
                                    placeholder="Country">
                            </div>
                        </div>
                    </div>

                    <?php // Show the error message if exists
                        if (isset($data) && !empty($data['error'])) {
                            $err = $data['error'];
                            if (is_object($err)) {
                                $msg = $err->getMessage();
                            } else {
                                $msg = (string)$err;
                            }
                            $msg = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');
                            echo "<div class=\"input-feedback w-100\"><p>{$msg}</p></div>";
                        }
                    ?>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-red my-4 w-100">
                        REGISTER
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/js/auth-utils.js"></script>
<script>
    
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function () {
            togglePassword('password', this);
        });
    }

    const togglePasswordConfirmBtn = document.getElementById('togglePasswordConfirmBtn');
    if (togglePasswordConfirmBtn) {
        togglePasswordConfirmBtn.addEventListener('click', function () {
            togglePassword('password_confirm', this);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.register-page form');
        if (!form) return;
            
        try { // Preguntar porque me pide removeEventListener antes de haver el addEventListener
            form.removeEventListener('submit', validateForm);
        } catch (e) {}
        form.addEventListener('submit', validateForm);
    });

</script>