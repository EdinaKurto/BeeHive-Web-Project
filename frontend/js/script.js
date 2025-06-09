$.spapp.debug = true;

const API_BASE = "http://localhost/BeeHive-Web-Project/backend";

// Determine role-based start view
const savedRole = localStorage.getItem("role");
const startView = savedRole === "admin" ? "#adminpanel" : "#dashboard";

// Initialize SPApp
var app = $.spapp({
    defaultView: startView,
    templateDir: "frontend/views/"
});

const staticViews = [
    "login", "register", "dashboard", "adminpanel", "shop",
    "product1", "blog", "blog1", "cart", "checkout",
    "profile", "orders", "orders_single", "about", "contact",
];

staticViews.forEach(view => {
    app.route({ view: view, load: `${view}.html` });
});

// LOGIN route
app.route({
    view: "login",
    load: "login.html",
    onCreate: function () {
        console.log("Login view loaded");
        const form = document.getElementById("login-form");

        if (form) {
            form.addEventListener("submit", async function (e) {
                e.preventDefault();

                const email = document.getElementById("login-email").value.trim();
                const password = document.getElementById("login-password").value;

                // Client-side validation
                if (!email || !password) {
                    alert("Both email and password are required.");
                    return;
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert("Invalid email format.");
                    return;
                }

                try {
                    const res = await fetch(`${API_BASE}/auth/login`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ email, password })
                    });

                    const contentType = res.headers.get("content-type");
                    let data;

                    if (res.ok && contentType?.includes("application/json")) {
                        data = await res.json();
                    } else {
                        const errorText = await res.text();
                        alert("Login failed:\n" + errorText);
                        return;
                    }

                    if (!data.token) {
                        alert(data.error || "Login failed: no token.");
                        return;
                    }

                    const role = (data.role === "admin" || data.role_id == 1 || data.role === "Admin") ? "admin" : "user";

                    localStorage.setItem("token", data.token);
                    localStorage.setItem("role", role);

                    window.location.hash = role === "admin" ? "#adminpanel" : "#dashboard";
                    updateUIBasedOnRole();

                } catch (err) {
                    console.error("Login error:", err);
                    alert("Login failed. Try again.");
                }
            });
        }
    }
});

// REGISTER route
app.route({
    view: "register",
    load: "register.html",
    onCreate: function () {
        console.log("Register view loaded");
        const form = document.getElementById("register-form");

        if (form) {
            form.addEventListener("submit", async function (e) {
                e.preventDefault();

                const email = document.getElementById("register-email").value.trim();
                const full_name = document.getElementById("register-username").value.trim();
                const password = document.getElementById("register-password").value;
                const confirm_password = document.getElementById("register-confirm-password").value;

                // Validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert("Please enter a valid email address.");
                    return;
                }

                if (full_name.length < 3) {
                    alert("Username must be at least 3 characters long.");
                    return;
                }

                if (password.length < 6) {
                    alert("Password must be at least 6 characters long.");
                    return;
                }

                if (password !== confirm_password) {
                    alert("Passwords do not match.");
                    return;
                }

                try {
                    const res = await fetch(`${API_BASE}/auth/register`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ email, full_name, password, confirm_password })
                    });

                    const contentType = res.headers.get("content-type");
                    let data;

                    if (res.ok && contentType?.includes("application/json")) {
                        data = await res.json();
                    } else {
                        const errorText = await res.text();
                        alert("Registration failed. Server said:\n" + errorText);
                        return;
                    }

                    if (!data.token) {
                        alert(data.error || "Registration failed.");
                        return;
                    }

                    const role = (data.role === "admin" || data.role_id === 1) ? "admin" : "user";
                    localStorage.setItem("token", data.token);
                    localStorage.setItem("role", role);

                    window.location.hash = role === "admin" ? "#adminpanel" : "#dashboard";
                    updateUIBasedOnRole();

                } catch (err) {
                    console.error("Register error:", err);
                    alert("Registration failed. Try again.");
                }
            });
        }
    }
});

// LOGOUT logic
document.addEventListener("DOMContentLoaded", () => {
    const logoutBtn = document.getElementById("logoutBtn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", function (e) {
            e.preventDefault();
            localStorage.removeItem("token");
            localStorage.removeItem("role");
            window.location.hash = "#login";
            updateUIBasedOnRole();
        });
    }

    updateUIBasedOnRole();
    app.run();
});

window.addEventListener("hashchange", updateUIBasedOnRole);

// Cart route (unchanged)
app.route({
    view: "cart",
    load: "cart.html",
    onCreate: function () {
        const token = localStorage.getItem("token");
        if (!token) {
            window.location.hash = "#login";
            return;
        }

        fetch(`${API_BASE}/cart`, {
            headers: { "Authorization": `Bearer ${token}` }
        })
        .then(res => {
            if (!res.ok) throw new Error("Server error");
            return res.json();
        })
        .then(items => {
            const cartBody = document.querySelector(".cart-table tbody");
            cartBody.innerHTML = "";

            items.forEach(item => {
                cartBody.innerHTML += `
                    <tr>
                        <td><button data-id="${item.product_id}" class="remove-btn">✖</button></td>
                        <td class="product-image"><img src="frontend/img/products/${item.product_id}.png" /></td>
                        <td class="product-name">${item.name}</td>
                        <td class="product-price">$${item.price}</td>
                        <td class="product-quantity">
                            <input type="number" min="1" value="${item.cart_quantity}" data-id="${item.product_id}" class="quantity-input" />
                        </td>
                        <td class="product-total">$${(item.price * item.cart_quantity).toFixed(2)}</td>
                    </tr>`;
            });

            attachCartListeners(token, API_BASE);
            updateSummary(token, API_BASE);
        })
        .catch(err => {
            console.error("Cart load failed:", err);
            alert("Failed to load cart. Are you logged in?");
        });
    }
});

function updateUIBasedOnRole() {
    const token = localStorage.getItem("token");
    const role = localStorage.getItem("role");

    const adminOnly = [
        document.getElementById("adminNav"),
        document.getElementById("manageProducts"),
        document.getElementById("manageUsers")
    ];

    adminOnly.forEach(el => {
        if (el) el.style.display = (role === "admin" ? "inline-block" : "none");
    });

    if (window.location.hash === "#adminpanel" && role !== "admin") {
        window.location.hash = "#dashboard";
    }

    if (!token && !["#login", "#register"].includes(window.location.hash)) {
        window.location.hash = "#login";
    }
}