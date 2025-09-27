<?php
require_once __DIR__ . '/../includes/header.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: ../tasks/index.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $result = $auth->register($username, $email, $password);
        if ($result === true) {
            $success = "Registration successful! Please login.";
            // Clear form fields after successful registration
            $_POST = array();
        } else {
            $error = $result;
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-plus"></i> Create Account</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST" action="" id="registerForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <div class="form-text">3-20 characters (letters, numbers, underscores only)</div>
                        <div class="invalid-feedback" id="usernameFeedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        <div class="form-text">Enter a valid email address</div>
                        <div class="invalid-feedback" id="emailFeedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">Minimum 8 characters with uppercase, lowercase, number, and special character</div>
                        <div class="password-strength mt-2">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" id="passwordStrengthBar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted" id="passwordStrengthText">Password strength</small>
                        </div>
                        <div class="invalid-feedback" id="passwordFeedback"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div class="form-text">Re-enter your password</div>
                        <div class="invalid-feedback" id="confirmPasswordFeedback"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="login.php" class="text-decoration-none">Already have an account? Login here</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/register.js"></script>
<?php include __DIR__ . '/../includes/footer.php'; ?>