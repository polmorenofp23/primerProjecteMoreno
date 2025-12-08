 <?php
// Display error if exists
$error = $data['error'] ?? null;
$errorFlash = isset($_GET['message']) && $_GET['message'] === 'registered' ? 
    new AppError(200, 'Registration successful! Please log in.') : null;
?>
<link rel="stylesheet" href="/css/auth-styles.css">
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background-color: #5A1F3D;">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6 col-lg-5">
            <!-- Logo -->
            <div class="text-center mb-4">
                <img src="/assets/icons/logo.png" alt="Logo" style="width: 80px; height: auto;" class="mb-3">
                <h1 class="text-white">REGISTER</h1>
            </div>

            <!-- Error Message -->
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?= htmlspecialchars($error->getName()) ?></strong>
                    <p class="mb-0"><?= htmlspecialchars($error->getMessage() ?: $error->getDescription()) ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Success Message -->
            <?php if ($errorFlash): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong>
                    <p class="mb-0"><?= htmlspecialchars($errorFlash->getMessage()) ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Register Form -->
            <form method="POST" action="?controller=Auth&action=doRegister" class="bg-white p-4 rounded">
                <!-- First Name -->
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" 
                           placeholder="John" required>
                </div>

                <!-- Last Name -->
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" 
                           placeholder="Doe">
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="your@email.com" required>
                    <div class="form-text">We'll never share your email with anyone else.</div>
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="yourUsername" required>
                </div>

                <!-- Date of Birth -->
                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="number" class="form-control" name="birth_day" 
                                   placeholder="DD" min="1" max="31">
                        </div>
                        <div class="col-4">
                            <input type="number" class="form-control" name="birth_month" 
                                   placeholder="MM" min="1" max="12">
                        </div>
                        <div class="col-4">
                            <input type="number" class="form-control" name="birth_year" 
                                   placeholder="YYYY" min="1900" max="2010">
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password" required>
                        <span class="input-group-text cursor-pointer" onclick="togglePassword('password')">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="passwordConfirm" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="passwordConfirm" 
                               name="password_confirm" placeholder="Confirm Password" required>
                        <span class="input-group-text cursor-pointer" onclick="togglePassword('passwordConfirm')">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <!-- Communication Preferences -->
                <div class="mb-3">
                    <h6>Communication Preferences</h6>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="contactClub" name="contact_club" value="1">
                        <label class="form-check-label" for="contactClub">
                            Agree to contact from club
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="contactThird" name="contact_third" value="1">
                        <label class="form-check-label" for="contactThird">
                            Agree to contact from third parties
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="leaderboard" name="leaderboard" value="1" required>
                        <label class="form-check-label" for="leaderboard">
                            I agree to my First name and Surname initial to be shown on the leaderboard
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-red w-100">
                    REGISTER
                </button>

                <!-- Terms & Login Link -->
                <div class="text-center mt-3">
                    <small class="text-muted">
                        BY REGISTERING AND USING THIS WEBSITE, YOU AGREE TO OUR
                        <a href="#" class="text-danger" style="text-decoration: none;">PRIVACY POLICY</a>.
                    </small>
                </div>

                <div class="text-center mt-2">
                    <small>
                        ALREADY HAVE AN ACCOUNT?
                        <a href="?controller=Auth&action=showLogin" class="text-danger" style="text-decoration: none; font-weight: bold;">
                            SIGN IN HERE
                        </a>
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .cursor-pointer {
        cursor: pointer;
    }
    .input-group-text {
        background-color: #fff;
        border-left: 0;
    }
    .form-control:focus {
        border-color: #C41E3A;
        box-shadow: 0 0 0 0.2rem rgba(196, 30, 58, 0.25);
    }
</style>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        if (field.type === 'password') {
            field.type = 'text';
        } else {
            field.type = 'password';
        }
    }
</script>