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
