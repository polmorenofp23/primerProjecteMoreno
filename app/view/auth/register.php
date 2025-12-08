<link rel="stylesheet" href="/css/auth-styles.css">
<div class="container-fluid register-page auth-bg">
        
    <?php include_once VIEW_PATH . '/partials/auth-header.php'; ?>   
    
    <div class="container-fluid d-flex align-items-center justify-content-center">
        <div class="form-card d-flex flex-column justify-content-center align-items-center bg-white p-5 col-md-8 col-lg-6 my-5">
            <div class="card-header">
                <h2 class="auth-form-title">REGISTER</h2>
            </div>

            <!-- Register Form -->
            <div class="card-body mt-4 w-100">
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
</div>
<script src="/js/auth-utils.js"></script>