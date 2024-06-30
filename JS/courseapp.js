$(document).ready(function () {
  // When the button to add a new row is clicked:
  $("#addRowBtn").click(function () {
    // Count the number of rows in the tables for diploma and degree
    var rowCountDip = $("#dipTableBody tr").length;
    var rowCountDeg = $("#degTableBody tr").length;
    var maxRows = 15; // Maximum number of rows allowed

    // Check if we haven't reached the maximum limit of rows:
    if (rowCountDip < maxRows && rowCountDeg < maxRows) {
      // Clone the first row of the diploma table
      var newRowDip = $("#dipTableBody tr:first").clone();

      // Clear the content of the new row
      newRowDip.find("input, select").val("");

      // Add the new row to the diploma table
      $("#dipTableBody").append(newRowDip);

      // Clone the first row of the degree table
      var newRowDeg = $("#degTableBody tr:first").clone();

      // Clear the content of the new row
      newRowDeg.find("input, select").val("");

      // Add the new row to the degree table
      $("#degTableBody").append(newRowDeg);
    } else {
      // If the maximum limit of rows is reached, show an alert
      $("#warningaddModal").modal("show");
    }
  });

  // When the button to remove a row is clicked:
  $("#removeRowBtn").click(function () {
    // Remove the last row from the diploma table if there's more than one row
    var rowCountDip = $("#dipTableBody tr").length;
    var rowCountDeg = $("#degTableBody tr").length;
    if (rowCountDip > 1 && rowCountDeg > 1) {
      $("#dipTableBody tr:last").remove();
      $("#degTableBody tr:last").remove();
    } else {
      // Show an alert if at least one table has only one row
      $("#warningremoveModal").modal("show");
    }
  });
});
