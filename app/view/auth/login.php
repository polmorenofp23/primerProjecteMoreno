<link rel="stylesheet" href="/css/auth-styles.css">
<div class="container-fluid login-page auth-bg">    
    
    <?php include_once VIEW_PATH . '/partials/auth-header.php'; ?>               

    <div class="container-fluid d-flex align-items-center justify-content-center">
        <div class="form-card d-flex flex-column justify-content-center align-items-center bg-white p-5 col-md-8 col-lg-6">
            <div class="card-header">
                <h2 class="auth-form-title">LOG IN</h2>
            </div>
            <!-- Login Form -->
            <div class="card-body mt-4 w-100">
                <form method="POST" action="?controller=Auth&action=doLogin" class="d-flex flex-column">
                    <!-- usrkey (Username or Email) -->
                    <div class="form-group mb-4">
                        <label for="usrkey" class="form-label">Username or Email</label>
                        <div class="input-group">
                            <input type="text" class="form-control p-3" id="usrkey" name="usrkey" 
                                placeholder="Enter your username or email" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control p-3" id="password" name="password" 
                                placeholder="Enter your password" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-red w-100 mt-4">
                        LOGIN
                    </button>

                    <!-- Register Link -->
                    <div class="text-center mt-3">
                        <small>
                            DON'T HAVE AN ACCOUNT?
                            <a href="?controller=Auth&action=showRegister" class="red-link">
                                REGISTER HERE
                            </a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>