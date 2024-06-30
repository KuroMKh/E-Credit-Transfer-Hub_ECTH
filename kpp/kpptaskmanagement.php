<?php
include '../config/kppauthentication.php';
include '../config/DbConfig.php';

// SQL query to fetch data from both degree and diploma courses tables
$query = "SELECT *  FROM assigntask ";

// Executing the SQL query
$result = mysqli_query($conn, $query);

// Initializing an empty array to store the fetched data
$data = array();

// Fetching data from the result set and storing it in the array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>ECTH | Kpp Task Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/kpptaskmanagement.css" />

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../JS/kpphome.js"></script>

</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><img src="../images/navicon.png" width="30" height="30" /> ECTH</h3>
                <small>E-Credit Transfer Hub</small>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="kpphome.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="active">
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
                echo '</button>';
                echo $_SESSION['response_text'];
                echo '</div>';

                // Clearing the session variables for response
                $_SESSION['response_type'] = '';
                $_SESSION['response_text'] = '';
            }
            ?>

            <div class="container container-card">
                <div class="card custom-card p-sm-2-3">
                    <div class="card-body">
                        <h6 class="card-title"><b>Submitted DCI Match Record</b></h6>
                        <div class="mb-3 row" style="max-width: 400px;">
                            <div class="col">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                            </div>
                        </div>
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-bordered">
                                <thead style="background-color: #002d72; color: white;">
                                    <tr>
                                        <th class="programme" rowspan="2">Programme</th>
                                        <th class="institution" rowspan="2">Previous Institution</th>
                                        <th colspan="2">Degree Course</th>
                                        <th colspan="2">Diploma Course</th>
                                        <th class="actions" colspan="2">Actions</th>
                                    </tr>
                                    <tr>
                                        <th>Degree Course Code</th>
                                        <th>Degree Course Name</th>
                                        <th>Diploma Course Code</th>
                                        <th>Diploma Course Name</th>
                                        <th>View</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <?php foreach ($data as $row): ?>
                                        <tr>
                                            <td class="programme"> <?php echo $row['dipprev_prog']; ?> </td>
                                            <td class="institution"><?php echo $row['dipprev_inst']; ?></td>
                                            <td><?php echo $row['degcode']; ?></td>
                                            <td><?php echo $row['degcourse']; ?></td>
                                            <td><?php echo $row['dipcode']; ?></td>
                                            <td><?php echo $row['dipcourse']; ?></td>
                                            <td>
                                                <form action="recordedtask.php" method="post">
                                                    <input type="hidden" name="courseID" value="<?php echo $row['ID']; ?>">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger delete-btn" data-toggle="modal"
                                                    data-target="#confirmDeleteModal"
                                                    data-degcode="<?php echo $row['degcode']; ?>"
                                                    data-degcourse="<?php echo $row['degcourse']; ?>"
                                                    data-dipcode="<?php echo $row['dipcode']; ?>"
                                                    data-dipcourse="<?php echo $row['dipcourse']; ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete the match for the following courses?<br><br>
                            Degree Course: <span id="modalDegCode"></span> - <span id="modalDegCourse"></span> <br>
                            Diploma Course: <span id="modalDipCode"></span> - <span id="modalDipCourse"></span>
                        </div>
                        <div class="modal-footer">
                            <form action="deletedcimatch.php" method="post">
                                <input type="hidden" name="record_id" value="<?php echo $row['ID']; ?>">
                                <button type="submit" class="btn btn-danger" id="confirmDeleteButton"
                                    name="delete_record">Delete</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('.delete-btn').click(function () {
                var degcode = $(this).data('degcode');
                var degcourse = $(this).data('degcourse');
                var dipcode = $(this).data('dipcode');
                var dipcourse = $(this).data('dipcourse');

                $('#modalDegCode').text(degcode);
                $('#modalDegCourse').text(degcourse);
                $('#modalDipCode').text(dipcode);
                $('#modalDipCourse').text(dipcourse);
            });
        });

        $(document).ready(function () {
            $('.alert .close').click(function () {
                $(this).parent().fadeOut('slow');
            });
        });

        $(document).ready(function () {
            $('#searchInput').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
                $('#tableBody tr').each(function () {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            $('.delete-btn').click(function () {
                var degcode = $(this).data('degcode');
                var degcourse = $(this).data('degcourse');
                var dipcode = $(this).data('dipcode');
                var dipcourse = $(this).data('dipcourse');

                $('#modalDegCode').text(degcode);
                $('#modalDegCourse').text(degcourse);
                $('#modalDipCode').text(dipcode);
                $('#modalDipCourse').text(dipcourse);
            });

            $('.alert .close').click(function () {
                $(this).parent().fadeOut('slow');
            });
        });

        $(document).ready(function () {
            // Function to close the alert when close button is clicked
            function closeAlert() {
                $(this).parent().fadeOut('slow');
            }

            // Attaching click event to close button dynamically for each alert
            $('.alert').each(function () {
                $(this).prepend('<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
            });

            // Attaching click event to newly added close buttons
            $(document).on('click', '.alert .close', closeAlert);
        });
    </script>

</body>

</html>