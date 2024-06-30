document.getElementById("confirmSubmit").addEventListener("click", function () {
  document.getElementById("submitForm").submit();
});
document.addEventListener("DOMContentLoaded", function () {
  var submitButton = document.getElementById("confirmSubmit");
  if (submitButton) {
    submitButton.disabled = true;
  }
});
