var UserService = {
  init: function () {
    let token = localStorage.getItem("token");
    if (token) {
      window.location.replace("index.html");
    }

    $("#login-form").validate({
      submitHandler: function (form) {
        let entity = Object.fromEntries(new FormData(form).entries());
        UserService.login(entity);
      }
    });
  },

  login: function (entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/login",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(entity),
      success: function (result) {
        localStorage.setItem("token", result.token);
        window.location.replace("index.html");
      },
      error: function (xhr) {
        toastr.error(xhr.responseText || "Login failed");
      }
    });
  },

  logout: function () {
    localStorage.clear();
    window.location.replace("login.html");
  },

  generateMenuItems: function () {
    const token = localStorage.getItem("token");
    const user = Utils.parseJwt(token);
    if (!user) return window.location.replace("login.html");

    let nav = "";
    let main = "";

    if (user.role === Constants.ADMIN_ROLE) {
      nav = `<li><a href="#admin">Admin Panel</a></li>`;
      main = `<section id="admin" data-load="admin.html"></section>`;
    } else {
      nav = `<li><a href="#dashboard">Dashboard</a></li>`;
      main = `<section id="dashboard" data-load="dashboard.html"></section>`;
    }

    $("#tabs").html(nav);
    $("#spapp").html(main);
  }
};
