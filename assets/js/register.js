document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const submitBtn = document.getElementById('submitBtn');
    
    // Password strength indicator
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('passwordStrengthText');
    
    // Real-time validation functions (VISUAL ONLY - doesn't block submission)
    function validateUsername() {
        const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
        if (!usernameRegex.test(username.value)) {
            showError(username, 'Username must be 3-20 characters (letters, numbers, underscores only)');
            return false;
        }
        showSuccess(username);
        return true;
    }
    
    function validateEmail() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            showError(email, 'Please enter a valid email address');
            return false;
        }
        showSuccess(email);
        return true;
    }
    
    function validatePassword() {
        updatePasswordStrength();
        
        if (password.value.length < 8) {
            showError(password, 'Password must be at least 8 characters long');
            return false;
        }
        
        // Check for password requirements (but don't block submission)
        const hasLower = /[a-z]/.test(password.value);
        const hasUpper = /[A-Z]/.test(password.value);
        const hasNumber = /[0-9]/.test(password.value);
        const hasSpecial = /[^A-Za-z0-9]/.test(password.value);
        
        if (!hasLower || !hasUpper || !hasNumber || !hasSpecial) {
            showError(password, 'For security: include uppercase, lowercase, number, and special character');
            return false;
        }
        
        showSuccess(password);
        return true;
    }
    
    function validateConfirmPassword() {
        if (confirmPassword.value !== password.value) {
            showError(confirmPassword, 'Passwords do not match');
            return false;
        }
        showSuccess(confirmPassword);
        return true;
    }
    
    function updatePasswordStrength() {
        let strength = 0;
        const value = password.value;
        
        if (value.length >= 8) strength += 25;
        if (/[a-z]/.test(value)) strength += 25;
        if (/[A-Z]/.test(value)) strength += 25;
        if (/[0-9]/.test(value)) strength += 15;
        if (/[^A-Za-z0-9]/.test(value)) strength += 10;
        
        strength = Math.min(strength, 100);
        strengthBar.style.width = strength + '%';
        
        // Update color and text based on strength
        if (strength < 40) {
            strengthBar.className = 'progress-bar bg-danger';
            strengthText.textContent = 'Weak password';
            strengthText.className = 'text-danger';
        } else if (strength < 70) {
            strengthBar.className = 'progress-bar bg-warning';
            strengthText.textContent = 'Medium strength';
            strengthText.className = 'text-warning';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            strengthText.textContent = 'Strong password';
            strengthText.className = 'text-success';
        }
        
        if (value.length === 0) {
            strengthText.textContent = 'Password strength';
            strengthText.className = 'text-muted';
            strengthBar.style.width = '0%';
        }
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
    
    // Event listeners for real-time validation (VISUAL FEEDBACK ONLY)
    username.addEventListener('input', validateUsername);
    username.addEventListener('blur', validateUsername);
    
    email.addEventListener('input', validateEmail);
    email.addEventListener('blur', validateEmail);
    
    password.addEventListener('input', function() {
        validatePassword();
        if (confirmPassword.value) validateConfirmPassword();
    });
    
    confirmPassword.addEventListener('input', validateConfirmPassword);
    
    // Form submission - JUST SHOW LOADING, DON'T BLOCK SUBMISSION
    form.addEventListener('submit', function(e) {
        // Always allow form submission - server will validate
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering...';
        // Form will submit normally to PHP
    });
});