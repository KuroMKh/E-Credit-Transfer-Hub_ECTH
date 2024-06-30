<?php
include '../config/kppauthentication.php';
include '../config/DbConfig.php';

// SQL query to fetch data from the student table where certain columns are not null
$query = "SELECT * FROM student WHERE fullname IS NOT NULL AND icnumber IS NOT NULL AND numbphone IS NOT NULL AND picture IS NOT NULL";

// Executing the SQL query
$result = mysqli_query($conn, $query);

// Initializing an empty array to store the fetched data
$data = array();

// Fetching data from the result set and storing it in the array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

$pendingCount = 0;
foreach ($data as $row) {
    if ($row['confirmationstatus'] == 'PENDING') {
        $pendingCount++;
    }
}

$completedCount = 0;
foreach ($data as $row) {
    if ($row['confirmationstatus'] == 'COMPLETED') {
        $completedCount++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>ECTH | Kpp Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/kpphome.css" />
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../JS/kpphome.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><img src="../images/navicon.png" width="30" height="30" /> ECTH</h3>
                <small>E-Credit Transfer Hub</small>
            </div>
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="kpphome.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="kpptaskmanagement.php"><i class="fa fa-list-ul"></i> DCI Task Management</a>
                </li>
                <li>
                    <a href="kppverifiedrecord.php"><i class="fa fa-check"></i> Verified DCI Record</a>
                </li>
            </ul>
            <ul class="list-unstyled CTAs">
                <li>
                    <a class="logout" data-toggle="modal" data-target="#exampleModalCenter">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Log Out
                    </a>
                </li>
            </ul>
        </nav>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-sign-out"></i>Logout?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">Are you sure you want to logout?</div>
                    <div class="modal-footer">
                        <form action="../config/kpplogoutconfig.php" method="post">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                No, Cancel
                            </button>
                            <button type=" button" class="btn btn-success" name="yes">
                                Yes, Log Out
                            </button>
                        </form>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info" style="background-color: #103cbe">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <h6 class="ml-auto">
                        <div class="profile-info">
                            <img src="<?php echo htmlspecialchars($_SESSION['kppprofilepic']); ?>" alt="Profile Image"
                                class="profile-image" style="width: 40px; height: 40px; border-radius: 50%;">
                            <?php if (isset($_SESSION['kppemail']))
                                echo $_SESSION['kppemail']; ?>
                        </div>
                    </h6>
                </div>
            </nav>

            <?php
            // Displaying alerts if any response is set in the session
            if (isset($_SESSION['response_type']) && $_SESSION['response_type'] != '') {
                $alert_type = '';
                $alert_title = '';

                // Determine the SweetAlert type and title based on response type
                switch ($_SESSION['response_type']) {
                    case 'success':
                        $alert_type = 'success';
                        $alert_title = 'Success!';
                        break;
                    case 'error':
                        $alert_type = 'error';
                        $alert_title = 'Error!';
                        break;
                    case 'warning':
                        $alert_type = 'warning';
                        $alert_title = 'Warning!';
                        break;
                    default:
                        $alert_type = 'info';
                        $alert_title = 'Info';
                        break;
                }

                // Display the SweetAlert
                echo '<script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(event) {
                    Swal.fire({
                        title: "' . $alert_title . '",
                        html: "' . $_SESSION['response_text'] . '", 
                        icon: "' . $alert_type . '",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = "kpphome.php";
                        }
                    });
                });
                </script>';

                // Clear the session variables for response
                $_SESSION['response_type'] = '';
                $_SESSION['response_text'] = '';
            }
            ?>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-xl-4">
                        <div class="card bg-c-yellow order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">Request Pending</h6>
                                <h2 class="text-right">
                                    <i class="fa fa-refresh f-left"></i><span><?php echo $pendingCount; ?></span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card bg-c-green order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">Request Completed</h6>
                                <h2 class="text-right">
                                    <i class="fa fa-check f-left"></i><span><?php echo $completedCount; ?></span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card shadow-2-strong" style="background-color: #f5f7fa">
                                <div class="card-body">

                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="searchInput"
                                            placeholder="Search by Matrix Number or Name..." />
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0" id="studentTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Matrix Number</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0;
                                                foreach ($data as $row) {
                                                    $count++;
                                                    echo "<tr>";
                                                    echo "<td>" . $count . "</td>";
                                                    echo "<td>" . $row["matrixnumber"] . "</td>";
                                                    echo "<td>" . $row["fullname"] . "</td>";
                                                    $statusColor = ($row["confirmationstatus"] == 'COMPLETED') ? '#00ff00' : '#ffd700';
                                                    echo "<td style='color: $statusColor; font-weight: bold;'>" . $row["confirmationstatus"] . "</td>";
                                                    echo '<td>
                                                        <form action="kppviewcourse.php" method="POST">
                                                            <input type="text" value="' . $row["matrixnumber"] . '" hidden id="matrix" name="matrix">
                                                            <button type="submit" class="btn btn-primary btn-sm">View</button>
                                                        </form>
                                                      </td>';
                                                    echo "</tr>";
                                                }
                                                ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
<script>

    function redirectToApplication() {
        // Redirect to the desired file
        window.location.href = 'kppviewcourse.php';
    }

    document.getElementById('searchInput').addEventListener('keyup', function () {
        var input = this.value.toLowerCase();
        var tableRows = document.querySelectorAll('#studentTable tbody tr');

        tableRows.forEach(function (row) {
            var matrixNumber = row.cells[1].textContent.toLowerCase();
            var name = row.cells[2].textContent.toLowerCase();
            if (matrixNumber.includes(input) || name.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

</html>