<?php
include '../config/smeauthentication.php';
include '../config/DbConfig.php';

// Fetch data from the database
$smeID = $_SESSION['smeID'];
$query = "SELECT subjectA, subjectB, similaritypercent FROM similarity WHERE sme1 = ? OR sme2 = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $smeID, $smeID);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>ECTH | SME Verified Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/kppverrecord.css" />
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
                    <a href="smehome.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="active">
                    <a href="smeverifiedrecord.php"><i class="fa fa-check"></i> Verified DCI Record</a>
                </li>
            </ul>
            <ul class="list-unstyled CTAs">
                <li><a class="logout" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-sign-out"
                            aria-hidden="true"></i> Log Out</a></li>
            </ul>
        </nav>

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-sign-out"></i>Logout?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">Are you sure you want to logout?</div>
                    <div class="modal-footer">
                        <form action="../config/smelogoutconfig.php" method="post">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">No, Cancel</button>
                            <button type="submit" class="btn btn-success" name="yes">Yes, Log Out</button>
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
                            <img src="<?php echo htmlspecialchars($_SESSION['smeprofilepic']); ?>" alt="Profile Image"
                                class="profile-image" style="width: 40px; height: 40px; border-radius: 50%;">
                            <?php if (isset($_SESSION['smeemail']))
                                echo $_SESSION['smeemail']; ?>
                        </div>
                    </h6>
                </div>
            </nav>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search..." />
                    </div>
                </div>
                <div class="table-container">
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Degree Subject</th>
                                    <th>Diploma Subject</th>
                                    <th>Syllabus Overlap%</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php foreach ($tasks as $task): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($task['subjectA']); ?></td>
                                        <td><?php echo htmlspecialchars($task['subjectB']); ?></td>
                                        <td> <?php
                                        if (isset($task['similaritypercent']) && $task['similaritypercent'] !== '') {
                                            echo htmlspecialchars($task['similaritypercent']) . '%';
                                        } else {
                                            echo '<span style="font-weight: bold; color: #ffd700;">In Progress</span>';
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tableBody");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                var found = false;
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        document.getElementById("searchInput").addEventListener("keyup", function () {
            searchTable();
        });
    </script>
</body>

</html>