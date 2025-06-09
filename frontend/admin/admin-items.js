$(document).ready(function () {
    loadItems();
    loadCategories();

    function loadItems() {
        RestClient.get("products", function (products) {
            renderItemsTable(products);
        });
    }

    function renderItemsTable(products) {
        const $table = $("#itemsTable");
        $table.empty().append(`
            <thead>
                <tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Qty</th><th>Actions</th></tr>
            </thead><tbody></tbody>
        `);

        const $tbody = $table.find("tbody");
        products.forEach(p => {
            $tbody.append(`
                <tr data-id="${p.product_id}">
                    <td>${p.product_id}</td>
                    <td>${p.name}</td>
                    <td>${p.category_name}</td>
                    <td>$${parseFloat(p.price_each).toFixed(2)}</td>
                    <td>${p.quantity}</td>
                    <td>
                        <button class="btn btn-sm btn-warning edit-item" data-id="${p.product_id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-item" data-id="${p.product_id}">Delete</button>
                    </td>
                </tr>
            `);
        });

        $('#itemsTable').DataTable();
    }

    function loadCategories() {
        RestClient.get("categories", function (categories) {
            $("select[name='category_id']").empty();
            categories.forEach(cat => {
                $("select[name='category_id']").append(`<option value="${cat.id}">${cat.name}</option>`);
            });
        });
    }

    $("#addItemForm").on("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        RestClient.uploadFile("products", formData, function () {
            toastr.success("Product added.");
            $("#addItemModal").modal("hide");
            loadItems();
        });
    });

    $(document).on("click", ".edit-item", function () {
        const id = $(this).data("id");
        RestClient.get(`products/${id}`, function (p) {
            const $form = $("#editItemForm").attr("data-id", id)[0];
            $form.reset();
            $($form).find("input[name='name']").val(p.name);
            $($form).find("input[name='quantity']").val(p.quantity);
            $($form).find("input[name='price_each']").val(p.price_each);
            $($form).find("input[name='description']").val(p.description);
            $($form).find("select[name='category_id']").val(p.category_id);
            $("#editItemModal").modal("show");
        });
    });

    $("#editItemForm").on("submit", function (e) {
        e.preventDefault();
        const productId = $(this).attr("data-id");
        const formData = new FormData(this);
        RestClient.uploadFile(`products/${productId}`, formData, function () {
            toastr.success("Product updated.");
            $("#editItemModal").modal("hide");
            loadItems();
        });
    });

    $(document).on("click", ".delete-item", function () {
        const id = $(this).data("id");
        if (!confirm("Are you sure you want to delete this product?")) return;
        RestClient.delete(`products/${id}`, {}, function () {
            toastr.success("Product deleted.");
            loadItems();
        });
    });
});