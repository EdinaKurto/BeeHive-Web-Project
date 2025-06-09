var UserService = {
  get_user: function () {
    RestClient.get("users/current", function (response) {
      $('input[name="first_name"]').val(response.first_name || "");
      $('input[name="last_name"]').val(response.last_name || "");
      $('input[name="email"]').val(response.email || "");
      $('input[name="phone_number"]').val(response.phone_number || "");
      $('input[name="address"]').val(response.address || "");
    }, function () {
      console.error("Error fetching user data.");
    });
  },

  editProfile: function () {
    const form = document.getElementById("edit_profile_form");
    const formData = new FormData(form);

    const data = {
      first_name: formData.get("first_name"),
      last_name: formData.get("last_name"),
      email: formData.get("email"),
      phone_number: formData.get("phone_number"),
      address: formData.get("address")
    };

    RestClient.put("users/update", data, function () {
      toastr.success("Profile updated successfully.");
      UserService.get_user();
    }, function (xhr) {
      const msg = (xhr.responseJSON || {}).message || "Something went wrong while updating your profile.";
      toastr.error(msg);
    });
  },

  deleteAccount: function () {
    const userId = localStorage.getItem("user_id");
    if (!userId) return toastr.error("User ID not found.");
    if (!confirm("Are you sure you want to delete your account? This action cannot be undone.")) return;

    Utils.block_ui("#profile");
    RestClient.delete(`users/delete/${userId}`, {}, function () {
      toastr.success("Your account has been deleted.");
      localStorage.clear();
      window.location.replace("#login");
    }, function () {
      toastr.error("Error deleting account.");
    });
    Utils.unblock_ui("#profile");
  }
};