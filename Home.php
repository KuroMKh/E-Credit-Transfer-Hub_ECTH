<?php
// Including necessary files for authentication and navigation
include 'config/authentication.php';
include 'config/navbar.php';
include 'config/DbConfig.php'; // Including the database configuration file

// SQL query to fetch data from both degree and diploma courses tables
$query = "SELECT DISTINCT d.uniszacoursecode AS degree_uniszacoursecode,
                 d.uniszacoursename AS degree_uniszacoursename,
                 d.uniszacredithour AS degree_uniszacredithour,
                 dip.dipcoursecode AS diploma_dipcoursecode,
                 dip.dipcoursename AS diploma_dipcoursename,
                 dip.dipcredithour AS diploma_dipcredithour,
                 dip.dipgrade AS diploma_dipgrade,
                 dip.dipfile AS diploma_dipfile,
                 d.status AS degree_status

          FROM degcourse d
          LEFT JOIN dipcourse dip ON d.id = dip.id
          WHERE d.matrixnumber = '" . $_SESSION['matrixnumber'] . "'";

// Executing the SQL query
$result = mysqli_query($conn, $query);

// Initializing an empty array to store the fetched data
$data = array();

// Fetching data from the result set and storing it in the array
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

$_SESSION['pdf_data'] = $data;
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="CSS/home.css">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="x-icon" href="images/Tab_Icon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .status-approved {
      color: #00ff00;
    }

    .status-rejected {
      color: #ff0000;/
    }

    .status-pending {
      color: #ffd700;
      /* Gold color */
    }
  </style>
  <title>Status | ECTH</title>
</head>

<body>

  <?php
  // Displaying alerts if any response is set
  if (isset($_SESSION['response_type']) && $_SESSION['response_type'] != '') {
    $bootstrap_class = '';

    // Determining the Bootstrap alert class based on response type
    switch ($_SESSION['response_type']) {
      case 'success':
        $bootstrap_class = 'alert-success';
        break;
      case 'error':
        $bootstrap_class = 'alert-danger';
        break;
      case 'warning':
        $bootstrap_class = 'alert-warning';
        break;
      default:
        $bootstrap_class = 'alert-info';
        break;
    }

    // Displaying the alert with close button
    echo '<div class="alert ' . $bootstrap_class . ' alert-dismissible fade show">';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">';
    echo '</button>';
    echo $_SESSION['response_text'];
    echo '</div>';

    // Clearing the session variables for response
    $_SESSION['response_type'] = '';
    $_SESSION['response_text'] = '';
  }
  ?>

  <!-- Modal -->
  <div class="modal fade" id="noDataModal" tabindex="-1" aria-labelledby="noDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content justify-content-center">
        <div class="modal-header">
          <h5 class="modal-title" id="noDataModalLabel">No Data Available</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Please apply for transfer courses to proceed with PDF generation.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Main container -->
  <div class="container mt-4">
    <!-- Status card -->
    <div class="card">
      <div class="card-header">
        <strong class="h5">Status of Submission</strong>
      </div>
      <div class="card-body">
        <?php
        if (isset($_SESSION['status'])) {
          $status = $_SESSION['status'];
          $color = "";

          switch ($status) {
            case "APPROVED":
              $color = "#00ff00";
              break;
            case "REJECTED":
              $color = "#ff0000";
              break;
            case "PARTIAL APPROVED":
              $color = "#ff9933";
              break;
            default:
              $color = "#ffd700"; // Default color for PENDING status
          }
          // Output the status with appropriate color styling
          echo "<span style='color: $color; font-weight: bold;'>$status</span>";
        } else {
          echo ""; // If status is not set, display nothing
        }
        ?>
      </div>
    </div>

    <!-- Table container -->
    <div class="table-container">
      <!-- Bootstrap table -->
      <table class="table table-bordered">
        <thead style="background-color: #002d72">
          <tr>
            <th class="course-code-column">UniSZA Course Code</th>
            <th class="course-name-column">UniSZA Course Name</th>
            <th class="credit-hour-column">UniSZA Credit Hour</th>
            <th class="course-code-column">Previous Institution Course Code</th>
            <th class="course-name-column">Previous Institution Course Name</th>
            <th class="credit-hour-column">Previous Institution Credit Hour</th>
            <th class="grade-column">Previous Institution Grade</th>
            <th class="file-column">Previous Institution Course DCI</th>
            <th class="narrow-column">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Looping through data array and displaying table rows
          foreach ($data as $row) {
            echo '<tr>';
            echo '<td class="course-code-column">' . htmlspecialchars($row['degree_uniszacoursecode']) . '</td>';
            echo '<td class="course-name-column">' . htmlspecialchars($row['degree_uniszacoursename']) . '</td>';
            echo '<td class="credit-hour-column">' . htmlspecialchars($row['degree_uniszacredithour']) . '</td>';
            echo '<td class="course-code-column">' . htmlspecialchars($row['diploma_dipcoursecode']) . '</td>';
            echo '<td class="course-name-column">' . htmlspecialchars($row['diploma_dipcoursename']) . '</td>';
            echo '<td class="credit-hour-column">' . htmlspecialchars($row['diploma_dipcredithour']) . '</td>';
            echo '<td class="grade-column">' . htmlspecialchars($row['diploma_dipgrade']) . '</td>';
            echo '<td class="file-column">';
            // Displaying 'View' button if dipfile is set
            if (isset($row['diploma_dipfile'])) {
              echo '<button class="btn btn-primary view-file" data-file-path="' . htmlspecialchars($row['diploma_dipfile']) . '">View</button>';
            }
            echo '</td>';
            // Displaying 'Pending' status
            $status_class = '';
            if ($row['degree_status'] == 'APPROVED') {
              $status_class = 'status-approved';
            } elseif ($row['degree_status'] == 'REJECTED') {
              $status_class = 'status-rejected';
            } elseif ($row['degree_status'] == 'PENDING') {
              $status_class = 'status-pending';
            }
            echo '<td class="narrow-column"><span class="' . $status_class . '" style="font-weight: bold;">' . htmlspecialchars($row['degree_status']) . '</span></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Button to generate PDF -->
    <button class="btn btn-primary" id="generate-pdf"><i class="fa fa-file-pdf-o"></i>
      Generate Slip</button>

  </div>


  <!-- JavaScript functions -->
  <script>

    // JavaScript to handle viewing the file
    $('.view-file').click(function () {
      // Retrieve the file path from the data attribute
      var filePath = $(this).data('file-path');
      // Opening the file in a new window or tab if available
      if (filePath) {
        window.open(filePath, '_blank');
      } else {
        // Displaying an alert if the file path is not set
        alert("File path is not available.");
      }
    });

    // Function to handle row removal
    function removeRow(button) {
      // Show the confirmation modal
      $('#confirmationModal').modal('show');

      // Retrieve the row to remove when confirming the action
      var rowToRemove = button.closest('tr');

      // Handle confirm button click
      $('#confirmSubmit').click(function () {
        // Remove the row from the DOM
        rowToRemove.remove();

        // Close the modal
        $('#confirmationModal').modal('hide');
      });
    }

    $(document).ready(function () {
      $('#generate-pdf').click(function () {
        if ($('tbody tr').length === 0) {
          // If no data available, show Bootstrap modal
          $('#noDataModal').modal('show');
        } else {
          // If data available, open the PHP script for PDF generation in a new tab
          window.open('generate_pdf.php', '_blank');
        }
      });
    });
  </script>
</body>

</html>