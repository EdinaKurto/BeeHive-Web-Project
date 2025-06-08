$(document).ready(function () {
    fetchOrders();

    function fetchOrders() {
        RestClient.get("order/user", function (orders) {
            renderOrdersTable(orders);
        });
    }

    function renderOrdersTable(orders) {
        const $tbody = $("#ordersTable tbody");
        $tbody.empty();

        orders.forEach(order => {
            const statusOptions = ["Pending", "Approved", "Shipped", "Delivered", "Canceled"]
                .map(status => `<option value="${status}" ${status === order.status_name ? "selected" : ""}>${status}</option>`)
                .join("");

            $tbody.append(`
                <tr>
                    <td>#${order.order_id}</td>
                    <td>${order.customer_name || "N/A"}</td>
                    <td>${order.product_names?.split(",").length || "?"}</td>
                    <td>
                        <select class="form-select order-status" data-id="${order.order_id}">
                            ${statusOptions}
                        </select>
                    </td>
                    <td>$${parseFloat(order.total_price || 0).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-success save-status" data-id="${order.order_id}" disabled>Save</button>
                        <button class="btn btn-sm btn-danger delete-order" data-id="${order.order_id}">Delete</button>
                    </td>
                </tr>
            `);
        });

        // Re-init DataTable
        $('#ordersTable').DataTable();
    }

    $(document).on("change", ".order-status", function () {
        const orderId = $(this).data("id");
        $(`.save-status[data-id="${orderId}"]`).prop("disabled", false);
    });

    $(document).on("click", ".save-status", function () {
        const orderId = $(this).data("id");
        const newStatus = $(`.order-status[data-id="${orderId}"]`).val();

        RestClient.put("order/status", {
            order_id: orderId,
            new_status_id: mapStatusToId(newStatus)
        }, function () {
            toastr.success("Order status updated.");
            fetchOrders();
        });
    });

    $(document).on("click", ".delete-order", function () {
        const orderId = $(this).data("id");
        if (!confirm(`Delete order #${orderId}?`)) return;

        RestClient.delete(`order/${orderId}`, {}, function () {
            toastr.success("Order deleted.");
            fetchOrders();
        });
    });

    function mapStatusToId(status) {
        return {
            "Pending": 1,
            "Approved": 2,
            "Shipped": 3,
            "Delivered": 4,
            "Canceled": 5
        }[status] || 1;
    }
});
