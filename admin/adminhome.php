<?php
include '../config/adminauthentication.php';
include '../config/DbConfig.php';

// SQL query to fetch data from kpplogin table
$query = "SELECT * FROM kpplogin";

// Executing the SQL query
$result = mysqli_query($conn, $query);

// Initializing an empty array to store the fetched data
$data = array();

// Fetching data from the result set and storing it in the array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Count the number of rows returned by the query
$kppCount = mysqli_num_rows($result);

// SQL query to fetch data from smelogin table
$query1 = "SELECT * FROM smelogin";

// Executing the SQL query
$result1 = mysqli_query($conn, $query1);

// Initializing an empty array to store the fetched data
$data1 = array();

// Fetching data from the result set and storing it in the array
while ($row1 = mysqli_fetch_assoc($result1)) {
    $data1[] = $row1;
}

// Count the number of rows returned by the query
$smeCount = mysqli_num_rows($result1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>ECTH | Admin Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/adminhome.css" />
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../JS/kpphome.js"></script>
    <style>
        .table-responsive {
            max-height: 200px;
            overflow-y: auto;
        }

        .search-input {
            margin-bottom: 10px;
        }
    </style>
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
                    <a href="adminhome.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="createkpp.php"><i class="fa fa-briefcase"></i> Create KPP</a>
                </li>
                <li>
                    <a href="createsme.php"><i class="fa fa-users"></i> Create SME</a>
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
                        <form action="../config/adminlogoutconfig.php" method="post">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">No, Cancel</button>
                            <button type="submit" class="btn btn-success" name="yes">Yes, Log Out</button>
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
                        <?php if (isset($_SESSION['adminemail']))
                            echo $_SESSION['adminemail']; ?>
                    </h6>
                </div>
            </nav>

            <?php
            if (isset($_SESSION['response_type']) && $_SESSION['response_type'] != '') {
                $bootstrap_class = '';

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

                echo '<div class="alert ' . $bootstrap_class . ' alert-dismissible fade show" role="alert">';
                echo $_SESSION['response_text'];
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';

                $_SESSION['response_type'] = '';
                $_SESSION['response_text'] = '';
            }
            ?>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-xl-4">
                        <div class="card bg-c-yellow order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">Total Ketua Pusat Pengajian (KPP)</h6>
                                <h2 class="text-right">
                                    <i class="fa fa-briefcase f-left"></i><span><?php echo $kppCount; ?></span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card bg-c-green order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">Total Subject Matter Expert (SME)</h6>
                                <h2 class="text-right">
                                    <i class="fa fa-users f-left"></i><span><?php echo $smeCount; ?></span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPP Table Section -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <strong class="text-primary">List Of KPP</strong>
                                    <button class="btn btn-link" type="button"
                                        onclick="toggleTable('kppTableCollapse')">
                                        <i class="fa fa-chevron-down"></i>
                                    </button>
                                </h5>
                            </div>
                            <div id="kppTableCollapse" class="collapse">
                                <div class="card-body">
                                    <input class="form-control search-input" type="text" id="kppSearch"
                                        placeholder="Search KPP...">
                                    <div class="table-responsive">
                                        <table id="kppTable" class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Staff Number</th>
                                                    <th scope="col">Name</th>
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
                                                    echo "<td>" . $row["kppnum"] . "</td>";
                                                    echo "<td>" . $row["fullname"] . "</td>";
                                                    echo "<td class='action-column'>";
                                                    echo "<form action='managekppinfo.php' method='post'>";
                                                    echo "<input type='hidden' name='kppID' value='" . $row['ID'] . "'>";
                                                    echo "<div class='btn-group' role='group'>";
                                                    echo "<button type='submit' class='btn btn-primary btn-sm mr-2'><i class='fa fa-briefcase'></i> View Kpp</button>";
                                                    echo "</div>";
                                                    echo "</form>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SME Table Section -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <strong class="text-primary">List Of SME</strong>
                                    <button class="btn btn-link" type="button"
                                        onclick="toggleTable('smeTableCollapse')">
                                        <i class="fa fa-chevron-down"></i>
                                    </button>
                                </h5>
                            </div>
                            <div id="smeTableCollapse" class="collapse">
                                <div class="card-body">
                                    <input class="form-control search-input" type="text" id="smeSearch"
                                        placeholder="Search SME...">
                                    <div class="table-responsive">
                                        <table id="smeTable" class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Staff Number</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0;
                                                foreach ($data1 as $row1) {
                                                    $count++;
                                                    echo "<tr>";
                                                    echo "<td>" . $count . "</td>";
                                                    echo "<td>" . $row1["smenum"] . "</td>";
                                                    echo "<td>" . $row1["fullname"] . "</td>";
                                                    echo "<td class='action-column'>";
                                                    echo "<form action='managesmeinfo.php' method='post'>";
                                                    echo "<input type='hidden'  name='smeID' value='" . $row1['ID'] . "' readonly>";
                                                    echo "<div class='btn-group' role='group'>";
                                                    echo "<button type='submit' class='btn btn-primary btn-sm mr-2'><i class='fas fa-user'></i> View Sme</button>";
                                                    echo "</div>";
                                                    echo "</form>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        function redirectToApplication() {
            window.location.href = 'kppviewcourse.php';
        }

        function toggleTable(tableId) {
            var table = document.getElementById(tableId);
            if (table.classList.contains('collapse')) {
                table.classList.remove('collapse');
            } else {
                table.classList.add('collapse');
            }
        }

        $(document).ready(function () {
            $("#kppSearch").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#kppTable tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $("#smeSearch").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#smeTable tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>