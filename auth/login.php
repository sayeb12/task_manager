<?php
require_once __DIR__ . '/../includes/header.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../tasks/index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    
    $result = $auth->login($username, $password);
    if ($result === true) {
        header("Location: ../tasks/index.php");
        exit();
    } else {
        $error = $result;
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> Login to Your Account</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Login Instructions:</h6>
                    <ul class="mb-0 small">
                        <li>Enter your registered username</li>
                        <li>Use the password you created during registration</li>
                        <li>Make sure your credentials are correct</li>
                    </ul>
                </div>

                <form method="POST" action="" id="loginForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <div class="form-text">Enter your registered username</div>
                        <div class="invalid-feedback" id="usernameFeedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Enter your password</div>
                        <div class="invalid-feedback" id="passwordFeedback"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="register.php" class="text-decoration-none">Don't have an account? Register here</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    
    function validateUsername() {
        if (username.value.trim().length < 3) {
            showError(username, 'Username must be at least 3 characters');
            return false;
        }
        showSuccess(username);
        return true;
    }
    
    function validatePassword() {
        if (password.value.length < 1) {
            showError(password, 'Password is required');
            return false;
        }
        showSuccess(password);
        return true;
    }
    
    function showError(input, message) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        const feedback = document.getElementById(input.id + 'Feedback');
        if (feedback) feedback.textContent = message;
    }
    
    function showSuccess(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        const feedback = document.getElementById(input.id + 'Feedback');
        if (feedback) feedback.textContent = '';
    }
    
    // Event listeners for real-time validation
    username.addEventListener('blur', validateUsername);
    password.addEventListener('blur', validatePassword);
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        if (!validateUsername()) isValid = false;
        if (!validatePassword()) isValid = false;
        
        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>