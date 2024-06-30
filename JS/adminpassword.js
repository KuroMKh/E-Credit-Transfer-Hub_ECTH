function togglePasswordVisibility() {
  var passwordInput = document.getElementById("password");
  var icon = document.querySelector(".toggle-password");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    icon.classList.remove("fa-eye-slash");
    icon.classList.add("fa-eye");
  } else {
    passwordInput.type = "password";
    icon.classList.remove("fa-eye");
    icon.classList.add("fa-eye-slash");
  }
}

$(document).ready(function () {
  // Dismiss alert when close button is clicked
  $(".alert .close").on("click", function () {
    $(this).parent().alert("close");
  });
});
