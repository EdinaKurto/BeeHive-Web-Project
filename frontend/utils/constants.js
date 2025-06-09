var Constants = {
    get_api_base_url: function () {
        if (location.hostname === "localhost") {
            return "http://localhost/BeeHive-Web-Project/backend"; 
        } else {
            return "https://beehive-knttn.ondigitalocean.app"; 
        }
    },
    USER_ROLE: "user",
    ADMIN_ROLE: "admin"
};
