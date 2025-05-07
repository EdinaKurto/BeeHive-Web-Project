// script.js - SPApp Setup

var app = $.spapp({
    defaultView: "#dashboard",
    templateDir: "frontend/views/"
});

// ========== Static Route Views ==========
const staticViews = [
    "login", "register", "dashboard", "adminpanel", "shop",
    "product1", "blog", "blog1", "cart", "checkout",
    "profile", "orders", "orders_single", "about", "contact"
];

staticViews.forEach(view => {
    app.route({ view: view, load: `${view}.html` });
});

// ========== Special Routes With Logic ==========

app.route({
    view: "shop",
    load: "shop.html",
    onCreate: function () {
        if (typeof setupShopInteractions === 'function') {
            setupShopInteractions();
        }
    }
});

app.route({
    view: "login",
    load: "login.html",
    onCreate: function () {
        const form = document.getElementById("login-form");
        const emailInput = document.getElementById("login-email");
        const passwordInput = document.getElementById("login-password");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");

        if (form) {
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                let valid = true;

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailInput.value.trim())) {
                    emailError.style.display = "block";
                    valid = false;
                } else {
                    emailError.style.display = "none";
                }

                if (passwordInput.value.length < 6) {
                    passwordError.style.display = "block";
                    valid = false;
                } else {
                    passwordError.style.display = "none";
                }

                if (valid) {
                    alert("Login successful (demo)");
                    window.location.hash = "#dashboard";
                }
            });
        }
    }
});

app.route({
    view: "register",
    load: "register.html",
    onCreate: function () {
        const form = document.getElementById("register-form");

        const email = document.getElementById("register-email");
        const username = document.getElementById("register-username");
        const password = document.getElementById("register-password");
        const confirmPassword = document.getElementById("register-confirm-password");

        const emailError = document.getElementById("register-email-error");
        const usernameError = document.getElementById("register-username-error");
        const passwordError = document.getElementById("register-password-error");
        const confirmError = document.getElementById("register-confirm-password-error");

        if (form) {
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                let valid = true;

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email.value.trim())) {
                    emailError.style.display = "block";
                    valid = false;
                } else {
                    emailError.style.display = "none";
                }

                if (username.value.trim().length < 3) {
                    usernameError.style.display = "block";
                    valid = false;
                } else {
                    usernameError.style.display = "none";
                }

                if (password.value.length < 6) {
                    passwordError.style.display = "block";
                    valid = false;
                } else {
                    passwordError.style.display = "none";
                }

                if (confirmPassword.value !== password.value) {
                    confirmError.style.display = "block";
                    valid = false;
                } else {
                    confirmError.style.display = "none";
                }

                if (valid) {
                    alert("Registered successfully (demo)");
                    window.location.hash = "#login";
                }
            });
        }
    }
});

app.run();
