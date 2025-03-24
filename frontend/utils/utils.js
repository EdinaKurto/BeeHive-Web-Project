const Utils = {
    init_spapp: function () {
        var app = $.spapp({
            defaultView: "#dashboard",
            templateDir: "frontend/views/"
        });
        app.run();
    }
}