$(document).ready(function () {
  // Toggle sidebar
  $("#sidebarCollapse").on("click", function () {
    $("#sidebar").toggleClass("active");
    $(this).toggleClass("active"); // Add 'active' class to the clicked button
  });

  // Activate clicked sidebar item
  $("#sidebar ul.components li").on("click", function () {
    $("#sidebar ul.components li").removeClass("active"); // Remove 'active' class from all list items
    $(this).addClass("active"); // Add 'active' class to the clicked list item
  });
});

function previewFile(input) {
  var preview = document.getElementById("previewImage");
  var file = input.files[0];
  var reader = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
  };

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "../images/userpeople.png";
  }
}
