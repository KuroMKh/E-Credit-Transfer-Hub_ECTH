//Hide Password Function
const passwordToggle = document.querySelector("#password-toggle");
const passwordIcon = document.querySelector("#password-icon");
const passwordField = document.querySelector("[name='password']");

passwordToggle.addEventListener("click", function () {
  const type =
    passwordField.getAttribute("type") === "password" ? "text" : "password";
  passwordField.setAttribute("type", type);

  if (type === "password") {
    passwordIcon.classList.remove("bi-eye");
    passwordIcon.classList.add("bi-eye-slash");
  } else {
    passwordIcon.classList.remove("bi-eye-slash");
    passwordIcon.classList.add("bi-eye");
  }
});

//Hide Confirm  Password Function
const c_passwordToggle = document.querySelector("#c-password-toggle");
const c_passwordIcon = document.querySelector("#c-password-icon");
const c_passwordField = document.querySelector("[name='c_password']");

c_passwordToggle.addEventListener("click", function () {
  const type =
    c_passwordField.getAttribute("type") === "password" ? "text" : "password";
  c_passwordField.setAttribute("type", type);

  if (type === "password") {
    c_passwordIcon.classList.remove("bi-eye");
    c_passwordIcon.classList.add("bi-eye-slash");
  } else {
    c_passwordIcon.classList.remove("bi-eye-slash");
    c_passwordIcon.classList.add("bi-eye");
  }
});
