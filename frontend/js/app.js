document.addEventListener("DOMContentLoaded", function () {
    function validateEmail(email, errorElement) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            errorElement.style.display = 'block';
            return false;
        } else {
            errorElement.style.display = 'none';
            return true;
        }
    }

    function validatePassword(password, errorElement) {
        if (password.length < 6) {
            errorElement.style.display = 'block';
            return false;
        } else {
            errorElement.style.display = 'none';
            return true;
        }
    }

    function showSection(sectionId) {
        document.querySelectorAll(".content-section").forEach(section => {
            section.style.display = "none";
        });
        document.getElementById(sectionId).style.display = "block";
    }

    // Handle SPA navigation
    document.querySelectorAll(".login-register-link").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            window.location.href = "register.html";
        });
    });

    document.querySelectorAll(".register-login-link").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            window.location.href = "login.html";
        });
    });

    // Login Form Submission
    if (document.getElementById("login-form")) {
        document.getElementById("login-form").addEventListener("submit", function (event) {
            event.preventDefault();
            const email = document.getElementById("login-email").value;
            const password = document.getElementById("login-password").value;

            if (validateEmail(email, document.getElementById("emailError")) && validatePassword(password, document.getElementById("passwordError"))) {
                alert("Login successful!");
                window.location.href = "dashboard.html"; // Redirect to dashboard after login
            }
        });
    }

    // Register Form Submission
    if (document.getElementById("register-form")) {
        document.getElementById("register-form").addEventListener("submit", function (event) {
            event.preventDefault();
            const email = document.getElementById("register-email").value;
            const username = document.getElementById("register-username").value;
            const password = document.getElementById("register-password").value;
            const confirmPassword = document.getElementById("register-confirm-password").value;

            if (password !== confirmPassword) {
                document.getElementById("register-confirm-password-error").style.display = "block";
                return;
            }

            if (validateEmail(email, document.getElementById("register-email-error")) && validatePassword(password, document.getElementById("register-password-error"))) {
                alert("Registration successful!");
                window.location.href = "login.html"; 
            }
        });
    }
});
