<link rel="stylesheet" href="/css/auth-styles.css">
<div class="container-fluid profile-page white-bg">
    <div class="container-fluid d-flex align-items-center justify-content-center">
        <div class="form-card d-flex flex-column justify-content-center align-items-center bg-white p-5 col-sm-10 my-5">
            <div class="card-header">
                <h2 class="auth-form-title">PROFILE</h2>
            </div>

            <div class="card-body px-5 pt-3 w-100">
                <?php
                    $user = $data['user'];

                    $userId = $user->getId();
                    $first = $user->getFirstName() ?? '';
                    $last = $user->getLastName() ?? '';
                    $username = $user->getUsername() ?? '';
                    $email = $user->getEmail() ?? '';
                    $phone = $user->getPhone() ?? '';

                    $street = $city = $postcode = $country = '';
                    if (method_exists($user, 'getAddress')) {
                        $addr = $user->getAddress();
                        if (is_array($addr)) {
                            $street = $addr['street'] ?? '';
                            $city = $addr['city'] ?? '';
                            $postcode = $addr['postcode'] ?? '';
                            $country = $addr['country'] ?? '';
                        }
                    }

                    $birth_day = $birth_month = $birth_year = '';
                    if ($user->getBirthDate()) {
                        $parts = explode('-', $user->getBirthDate());
                        if (count($parts) === 3) {
                            $birth_year = $parts[0];
                            $birth_month = $parts[1];
                            $birth_day = $parts[2];
                        }
                    }
                ?>

                <form method="POST" action="?controller=User&action=update" class="d-flex flex-column" novalidate>
                    <!-- Spoof PUT method -->
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($userId, ENT_QUOTES, 'UTF-8'); ?>">

                    <legend class="form-label">User Identifier</legend>
                    <!-- First Name -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" id="firstname" name="first_name"
                                placeholder="First name" value="<?php echo htmlspecialchars($first, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" id="lastname" name="last_name"
                                placeholder="Last name" value="<?php echo htmlspecialchars($last, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" id="username" name="username"
                                placeholder="Username" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group d-flex flex-column justify-content-center">
                            <input type="email" class="form-control w-100 p-3" id="email" name="email"
                                placeholder="Email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                    </div>

                     <!-- Phone -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group">
                            <input type="tel" class="form-control p-3" id="phone" name="phone"
                                placeholder="Phone number" value="<?php echo htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>

                    <!-- Password  -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-password">
                            <input type="password" class="form-control p-3" id="password" name="password"
                                placeholder="Enter new password (leave blank to keep current)">
                            <button type="button" class="password-toggle" id="togglePasswordBtn" aria-label="Toggle password visibility">
                                <i data-lucide="eye" class="icon-grey"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-password">
                            <input type="password" class="form-control p-3" id="password_confirm" name="password_confirm"
                                placeholder="Confirm new password">
                            <button type="button" class="password-toggle" id="togglePasswordConfirmBtn" aria-label="Toggle password confirmation visibility">
                                <i data-lucide="eye" class="icon-grey"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Date of Birth -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <legend class="form-label">Date of Birth</legend>
                        <div class="input-group row g-2">
                            <div class="col-4">
                                <input type="number" class="form-control p-3" name="birth_day"
                                    placeholder="DD" min="1" max="31" value="<?php echo htmlspecialchars($birth_day, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control p-3" name="birth_month"
                                    placeholder="MM" min="1" max="12" value="<?php echo htmlspecialchars($birth_month, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="col-4">
                                <input type="number" class="form-control p-3" name="birth_year"
                                    placeholder="YYYY" min="1900" max="2026" value="<?php echo htmlspecialchars($birth_year, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <legend class="form-label">Address</legend>
                        <div class="input-group">
                            <input type="text" class="form-control p-3 mb-2" id="street" name="address_street"
                                placeholder="Street" value="<?php echo htmlspecialchars($street, ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="d-flex g-2">
                                <input type="text" class="form-control p-3 me-2" id="city" name="address_city"
                                    placeholder="City" value="<?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="text" class="form-control p-3 me-2" id="postcode" name="address_postcode"
                                    placeholder="Postcode" value="<?php echo htmlspecialchars($postcode, ENT_QUOTES, 'UTF-8'); ?>">
                                <input type="text" class="form-control p-3" id="country" name="address_country"
                                    placeholder="Country" value="<?php echo htmlspecialchars($country, ENT_QUOTES, 'UTF-8'); ?>">
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
                    <button type="submit" class="btn-red w-100 py-3 my-4">
                        UPDATE PROFILE
                    </button>

                    <div class="text-center my-2">
                        <small class="text-muted">
                            Leave password fields blank to keep your current password
                        </small>
                    </div>
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
        const form = document.querySelector('.profile-page form');
        if (!form) return;
        try { form.removeEventListener('submit', validateForm); } catch (e) {}
        form.addEventListener('submit', validateForm);
    });
</script>
