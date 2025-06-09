const Utils = {
    init_spapp: function () {
        var app = $.spapp({
            defaultView: "#landing",
            templateDir: "views/"
        });

        app.route({
            view: "dashboard",
            onReady: function () {
                ProductService.handleNavbarSearch();
                ProductService.loadUserProductViews();
                ProductService.loadDashboardSummary();
                OrderService.getUserOrders();
                UserService.updateDashboardLink();
            }
        });

        app.route({
            view: "profile",
            onReady: function () {
                ProductService.handleNavbarSearch();
                UserService.init();
                UserService.getUserData();
                UserService.updateDashboardLink();
            }
        });

        app.route({
            view: "shopping_cart",
            onReady: function () {
                ProductService.handleNavbarSearch();
                CartService.getCart();
                UserService.updateDashboardLink();
                CartService.initPurchaseFormValidation();
            }
        });

        app.route({
            view: "admin_dashboard",
            onReady: function () {
                ProductService.handleNavbarSearch();
                ProductService.init();
                ProductService.getAllProducts();
                OrderService.getAllOrders();
                UserService.updateDashboardLink();
            }
        });

        app.route({
            view: "products",
            onReady: function () {
                ProductService.handleNavbarSearch();
                ProductService.renderCategoryCheckboxes();
                UserService.updateDashboardLink();

                const searchInput = document.getElementById("navbar-search-input");
                const searchTerm = localStorage.getItem("products_search_term") || "";
                localStorage.removeItem("products_search_term");
                if (searchInput) searchInput.value = searchTerm;
                ProductService.loadProducts(searchTerm ? { search: searchTerm } : {});
            }
        });

        app.route({
            view: "wishlist",
            onReady: function () {
                ProductService.handleNavbarSearch();
                WishlistService.getWishlist();
                UserService.updateDashboardLink();
            }
        });

        app.run();
    },

    block_ui: function (element) {
        $(element).block({
            message: '<div class="spinner-border text-success" role="status"></div>',
            css: {
                backgroundColor: "transparent",
                border: "0",
            },
            overlayCSS: {
                backgroundColor: "#000",
                opacity: 0.25,
            },
        });
    },

    unblock_ui: function (element) {
        $(element).unblock({});
    },

    datatable: function (table_id, columns, data, pageLength = 15) {
        if ($.fn.dataTable.isDataTable("#" + table_id)) {
            $("#" + table_id).DataTable().destroy();
        }

        $("#" + table_id).DataTable({
            data: data,
            columns: columns,
            pageLength: pageLength,
            lengthMenu: [2, 5, 10, 15, 25, 50, 100, "All"],
        });
    },

    parseJwt: function (token) {
        if (!token) return null;
        try {
            const payload = token.split('.')[1];
            const decoded = atob(payload);
            return JSON.parse(decoded);
        } catch (e) {
            console.error("Invalid JWT token", e);
            return null;
        }
    }
};
