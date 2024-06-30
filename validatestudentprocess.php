<head>
  <!-- Include jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- Include SweetAlert2 library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
</head>

<?php
// Include database configuration file
include 'config/DbConfig.php';
// Start PHP session
session_start();

// Check if form is submitted
if (isset ($_POST['validate'])) {
  // Get form data
  $uniszaemail = $_POST['uniszaemail'] . "@putra.unisza.edu.my";
  $matrixnumber = $_POST['uniszaemail'];
  $password = $_POST['password'];
  $c_password = $_POST['c_password'];

  // Check if passwords match
  if ($password !== $c_password) {
    // Set response type and message for warning
    $_SESSION['response_type'] = 'warning';
    $_SESSION['response_text'] = 'Password does not match.';
    // Redirect back to the validation page
    header("Location: validateStudent.php");
    exit(); // Stop further execution
  }

  // Encrypt the password
  $e_password = password_hash($password, PASSWORD_DEFAULT);
  // Check if the email already exists in the database
  $checkstudentemail = "SELECT * FROM login WHERE uniszaemail = '$uniszaemail'";
  $result_email = mysqli_query($conn, $checkstudentemail);
  $count_email = mysqli_num_rows($result_email);

  // If email already exists, show error message
  if ($count_email > 0) {
    $_SESSION['response_type'] = 'error';
    $_SESSION['response_text'] = 'The email ' . $uniszaemail . ' is already validated.';
    header("Location: validateStudent.php");
    exit();
  } else {
    // If email does not exist, proceed with registration

    // Insert student data into the database
    $insert = "INSERT into student (matrixnumber) values ('$matrixnumber')";
    $conn->query($insert);

    // Insert academic data into the database
    $insert = "INSERT into academic (matrixnumber) values ('$matrixnumber')";
    $conn->query($insert);

    // Insert diploma data into the database
    $insert = "INSERT into diploma (matrixnumber) values ('$matrixnumber')";
    $conn->query($insert);

    // Insert address data into the database
    $insert = "INSERT into address (matrixnumber) values ('$matrixnumber')";
    $conn->query($insert);

    // Insert login data into the database
    $insert = "INSERT into login (uniszaemail, matrixnumber, password) values ('$uniszaemail', '$matrixnumber', '$e_password')";
    // If insertion is successful, show success message
    if ($conn->query($insert)) {
      echo '<script type="text/javascript">
                $(document).ready(function(){
                    Swal.fire({
                        title: "Completed!",
                        text: "Account Validated!",
                        icon: "success"
                      }).then((result) => {
                        if (result.isConfirmed) {
                          // Redirect to student login page
                          window.location.href = "studentlogin.php";
                        }
                      });
                });
                </script> ';
    } else {
      // If insertion fails, show error message
      echo '<script type="text/javascript">
                $(document).ready(function(){
                    Swal.fire({
                        title: "Failure!",
                        text: "Account Not Validated!",
                        icon: "error"
                      }).then((result) => {
                        if (result.isConfirmed) {
                          // Redirect back to validation page
                          window.location.href = "validateStudent.php";
                        }
                      });
                });
                </script> ';
    }
  }
}
?>