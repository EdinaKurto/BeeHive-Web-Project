export const CartService = {
    getCart: () => {
        return $.getJSON("/cart");
    },
    getSummary: () => {
        return $.getJSON("/cart/summary");
    },
    addToCart: (productId) => {
        return $.ajax({
            url: "/cart/add",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify({ product_id: productId })
        });
    },
    updateQuantity: (productId, quantity) => {
        return $.ajax({
            url: "/cart/update",
            method: "PUT",
            contentType: "application/json",
            data: JSON.stringify({ product_id: productId, quantity })
        });
    },
    removeFromCart: (productId) => {
        return $.ajax({
            url: `/cart/remove/${productId}`,
            method: "DELETE"
        });
    },
    clearCart: () => {
        return $.ajax({
            url: "/cart/clear",
            method: "DELETE"
        });
    }
};