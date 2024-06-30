<?php
include '../config/kppauthentication.php';
include '../config/DbConfig.php';


// SQL query to fetch data from the assigntask table
$query_assigntask = "SELECT * FROM assigntask";

// Executing the SQL query
$result_assigntask = mysqli_query($conn, $query_assigntask);

// Initializing an empty array to store the fetched data
$data_assigntask = array();

// Fetching data from the result set and storing it in the array
while ($row_assigntask = mysqli_fetch_assoc($result_assigntask)) {
    $data_assigntask[$row_assigntask['ID']] = $row_assigntask;
}

// SQL query to fetch data from the similarity table
$query_similarity = "SELECT * FROM similarity";

// Executing the SQL query
$result_similarity = mysqli_query($conn, $query_similarity);

// Initializing an empty array to store the fetched data
$data_similarity = array();

// Fetching data from the result set and storing it in the array
while ($row_similarity = mysqli_fetch_assoc($result_similarity)) {
    $data_similarity[$row_similarity['ID']] = $row_similarity;
}

// SQL query to fetch data from the similarity table
$query_similarity = "SELECT * FROM similarity";

// Executing the SQL query
$result_similarity = mysqli_query($conn, $query_similarity);

// Initializing an empty array to store the fetched data
$data_similarity = array();

// Fetching data from the result set and storing it in the array
while ($row_similarity = mysqli_fetch_assoc($result_similarity)) {
    $data_similarity[$row_similarity['ID']] = $row_similarity;
}

// Merging data
$merged_data = array();

foreach ($data_assigntask as $task_id => $assigntask_row) {
    if (isset($data_similarity[$task_id])) {
        $merged_data[] = array_merge($assigntask_row, $data_similarity[$task_id]);
    } else {
        $merged_data[] = $assigntask_row; // Or handle cases where there is no matching similarity record
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
                <li><a href="kpphome.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="kpptaskmanagement.php"><i class="fa fa-list-ul"></i> DCI Task Management</a></li>
                <li class="active"><a href="kppverifiedrecord.php"><i class="fa fa-check"></i> Verified DCI Record</a>
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
                        <form action="../config/kpplogoutconfig.php" method="post">
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
                            <img src="<?php echo htmlspecialchars($_SESSION['kppprofilepic']); ?>" alt="Profile Image"
                                class="profile-image" style="width: 40px; height: 40px; border-radius: 50%;">
                            <?php if (isset($_SESSION['kppemail']))
                                echo $_SESSION['kppemail']; ?>
                        </div>
                    </h6>
                </div>
            </nav>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search..." />
                    </div>
                    <div class="col-md-6 mb-3">
                        <form action="generate_excel.php" method="post">
                            <button type="submit" name="export_excel" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Export to Excel
                            </button>
                        </form>
                    </div>
                </div>
                <div class="table-container">
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2">Institution</th>
                                    <th rowspan="2">Programme</th>
                                    <th colspan="2">Degree Course</th>
                                    <th colspan="3">Diploma Course</th>
                                    <th rowspan="2">Syllabus Overlap%</th>
                                    <th rowspan="2">Review</th>
                                </tr>
                                <tr>
                                    <th>Degree Course Code</th>
                                    <th>Degree Course Name</th>
                                    <th>Diploma Course Code</th>
                                    <th>Diploma Course Name</th>
                                    <th>Diploma Credit Hour</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php foreach ($merged_data as $row): ?>
                                    <tr>
                                        <td><?php echo $row['dipprev_inst']; ?></td>
                                        <td><?php echo $row['dipprev_prog']; ?></td>
                                        <td><?php echo $row['degcode']; ?></td>
                                        <td><?php echo $row['degcourse']; ?></td>
                                        <td><?php echo $row['dipcode']; ?></td>
                                        <td><?php echo $row['dipcourse']; ?></td>
                                        <td><?php echo $row['dipcredithour']; ?></td>
                                        <td>
                                            <?php
                                            if (isset($row['similaritypercent'])) {
                                                echo $row['similaritypercent'] . '%';
                                            } else {
                                                echo '<span style="color: #ffd700;"><strong>In Progress</strong></span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="review-content" style="text-align: justify;">
                                                <strong style="color: #ff9933;">SME 1's Review :</strong>
                                                <?php
                                                if (isset($row['review1'])) {
                                                    echo htmlspecialchars($row['review1']);
                                                } else {
                                                    echo '<span style="color: #ffd700;"><strong>No review yet</strong></span>';
                                                }
                                                ?>
                                                <br>
                                                <br>
                                                <strong style="color: #4CAF50;">SME 2's Review :</strong>
                                                <?php
                                                if (isset($row['review2'])) {
                                                    echo htmlspecialchars($row['review2']);
                                                } else {
                                                    echo '<span style="color: #ffd700;"><strong>No review yet</strong></span>';
                                                }
                                                ?>
                                            </div>
                                            <span class="see-more" onclick="toggleReview(this)">See more</span>
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
        function toggleReview(element) {
            var reviewContent = element.previousElementSibling;
            var expandedReview = document.querySelector(".review-content.expanded");
            if (expandedReview && expandedReview !== reviewContent) {
                expandedReview.classList.remove("expanded");
                expandedReview.nextElementSibling.textContent = "See more";
            }
            if (reviewContent.classList.contains("expanded")) {
                reviewContent.classList.remove("expanded");
                element.textContent = "See more";
            } else {
                reviewContent.classList.add("expanded");
                element.textContent = "See less";
            }
        }

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