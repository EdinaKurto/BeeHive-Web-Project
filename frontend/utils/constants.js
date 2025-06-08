var Constants = {
    get_api_base_url: function () {
        if (location.hostname === "localhost") {
            return "http://localhost/BeeHive-Web-Project/backend"; 
        } else {
            return "https://your-production-domain.com"; 
        }
    },
    USER_ROLE: "user",
    ADMIN_ROLE: "admin"
};
