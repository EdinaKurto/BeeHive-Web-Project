export const OrderService = {
    createOrder: (orderData) => {
        return $.ajax({
            url: "/order/add",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(orderData)
        });
    },
    getMyOrders: () => {
        return $.getJSON("/order/user");
    },
    updateOrderStatus: (orderId, newStatusId) => {
        return $.ajax({
            url: "/order/status",
            method: "PUT",
            contentType: "application/json",
            data: JSON.stringify({ order_id: orderId, new_status_id: newStatusId })
        });
    }
};