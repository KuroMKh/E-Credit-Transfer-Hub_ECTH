<?php
include '../config/kppauthentication.php';
include '../config/DbConfig.php';

if (isset($_POST['courseID']) && !empty($_POST['courseID'])) {
    // Get the courseID from the form
    $courseID = $_POST['courseID'];

    // Prepare the SQL query to fetch data for the specific ID
    $query = "SELECT * FROM assigntask WHERE ID = $courseID";

    // Executing the SQL query
    $result = mysqli_query($conn, $query);

    // Initializing an empty array to store the fetched data
    $data = array();

    // Fetching data from the result set and storing it in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

$sql1 = "SELECT DISTINCT uniszacoursecode, uniszacoursename, uniszacredithour FROM degcourse";
$sql2 = "SELECT DISTINCT prev_inst  FROM diploma";
$sql3 = "SELECT DISTINCT dipcoursecode, dipcoursename, dipcredithour FROM dipcourse";
$sql4 = "SELECT DISTINCT prev_prog  FROM diploma";


$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Kpp | Edit Submission</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/editdcimatch.css" />
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>

<body>
    <!-- Centered navbar with shadow -->
    <div class="container-fluid d-flex justify-content-center">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <!-- Left side of the navbar -->
                <div>
                    <form action="kpptaskmanagement.php">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </form>
                </div>

                <div class="navbar-text-container">
                    <div class="navbar-text">
                        <strong>Recorded Task</strong>
                    </div>
                </div>

                <!-- Right side of the navbar -->
                <div class="navbar-nav ms-auto">
                    <form action="kpptaskmanagement.php">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </div>



    <div class="container mt-5 shadow-lg">
        <!-- Header with Background Color -->
        <div class="header-bg d-flex justify-content-between align-items-center">
            <!-- Header Title -->
            <h2 class="header-title">Task Submission Details</h2>
            <li class="list-group-item">
                <strong>Task assigned on:</strong> <?php echo date("d/m/y h:i A", strtotime($data[0]["datetime"])); ?>
            </li>
        </div>

        <!-- First Container Content -->
        <div id="firstContainer">
            <div class="row card-container">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="card-title" style="font-weight: bold;">UniSZA Course</h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Course Code:</strong> <?php echo $data[0]["degcode"]; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Course Name:</strong> <?php echo $data[0]["degcourse"]; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Course DCI:</strong> <a
                                        href="http://localhost/FYP(CTA)/taskdci/<?php echo $data[0]["degdci"]; ?>"
                                        target="_blank"><?php echo basename($data[0]["degdci"]); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="card-title" style="font-weight: bold;">Diploma Course</h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Previous Institution:</strong> <?php echo $data[0]["dipprev_inst"]; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Previous Programme:</strong> <?php echo $data[0]["dipprev_prog"]; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Course Code:</strong> <?php echo $data[0]["dipcode"]; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Course Name:</strong> <?php echo $data[0]["dipcourse"]; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Credit Hour:</strong> <?php echo $data[0]["dipcredithour"]; ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Course DCI:</strong> <a
                                        href="http://localhost/FYP(CTA)/<?php echo $data[0]["dipdci"]; ?>"
                                        target="_blank"><?php echo basename($data[0]["dipdci"]); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4 class="card-title" style="font-weight: bold;">Assigned SME</h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>First SME:</strong>
                                    <?php
                                    $firstsme_id = $data[0]["firstsme"];
                                    $firstsme_query = "SELECT fullname FROM smelogin WHERE ID = $firstsme_id";
                                    $firstsme_result = mysqli_query($conn, $firstsme_query);
                                    if ($firstsme_result && mysqli_num_rows($firstsme_result) > 0) {
                                        $firstsme_name = mysqli_fetch_assoc($firstsme_result)["fullname"];
                                        echo $firstsme_name;
                                    } else {
                                        echo "Not Assigned";
                                    }
                                    ?>
                                </li>
                                <li class="list-group-item">
                                    <strong>Second SME:</strong>
                                    <?php
                                    $secsme_id = $data[0]["secsme"];
                                    $secsme_query = "SELECT fullname FROM smelogin WHERE ID = $secsme_id";
                                    $secsme_result = mysqli_query($conn, $secsme_query);
                                    if ($secsme_result && mysqli_num_rows($secsme_result) > 0) {
                                        $secsme_name = mysqli_fetch_assoc($secsme_result)["fullname"];
                                        echo $secsme_name;
                                    } else {
                                        echo "Not Assigned";
                                    }
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>