<link rel="stylesheet" href="/css/auth-styles.css">
<div class="container-fluid login-page dark-red-bg min-vh-100 pt-3">    

    <?php include_once VIEW_PATH . '/partials/auth-header.php'; ?>

    <div class="container-fluid d-flex align-items-center justify-content-center">
        <div class="form-card d-flex flex-column justify-content-center align-items-center bg-white p-5 col-md-8 col-lg-6 my-5">
            <div class="card-header">
                <h2 class="auth-form-title">LOG IN</h2>
            </div>

            <!-- Login Form -->
            <div class="card-body px-5 pt-5 w-100">
                <form method="POST" action="?controller=Auth&action=doLogin" class="d-flex flex-column" novalidate>
                    <!-- usrkey (Username or Email) -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" id="usrkey" name="usrkey"
                                placeholder="Enter your username or email" required value="<?= htmlspecialchars(
                                    $old['usrkey'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group my-2 d-flex flex-column justify-content-center">
                        <div class="input-password">
                            <input type="password" class="form-control p-3" id="password" name="password"
                                placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" id="togglePasswordBtn" aria-label="Toggle password visibility">
                                <i data-lucide="eye" class="icon-grey"></i>
                            </button>
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
                    <button type="submit" class="btn-red w-100 mt-5 mb-4">
                        LOGIN
                    </button>

                    <!-- Register Link -->
                    <div class="text-center my-2">
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
<script src="/js/auth-utils.js"></script>
<script>
    
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function () {
            togglePassword('password', this);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.login-page form');
        if (!form) return;
            
        try { // Preguntar al david porque me pide removeEventListener antes de haver el addEventListener
            form.removeEventListener('submit', validateForm);
        } catch (e) {}
        form.addEventListener('submit', validateForm);
    });

</script>