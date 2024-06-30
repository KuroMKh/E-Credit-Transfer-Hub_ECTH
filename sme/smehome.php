<?php
include '../config/smeauthentication.php';
include '../config/DbConfig.php';

$pendingCount = 0;
$approvedCount = 0;
$rejectedCount = 0;
$smeID = $_SESSION['smeID'];

$query = "SELECT * FROM similarity WHERE sme1 = ? OR sme2 = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $smeID, $smeID);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
    if ($row['status'] == 'PENDING') {
        $pendingCount++;
    } elseif ($row['status'] == 'APPROVED') {
        $approvedCount++;
    } elseif ($row['status'] == 'REJECTED') {
        $rejectedCount++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>ECTH | Sme Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/smehome.css" />
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
                <li class="active">
                    <a href="smehome.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="smeverifiedrecord.php"><i class="fa fa-check"></i> Verified DCI Record</a>
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
                        <form action="../config/smelogoutconfig.php" method="post">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                No, Cancel
                            </button>
                            <button type="submit" class="btn btn-success" name="yes">
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
                        <img src="<?php echo htmlspecialchars($_SESSION['smeprofilepic']); ?>" alt="Profile Image"
                            class="profile-image" style="width: 40px; height: 40px; border-radius: 50%;">
                        <?php if (isset($_SESSION['smeemail']))
                            echo $_SESSION['smeemail']; ?>
                    </h6>
                </div>
            </nav>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-xl-4">
                        <div class="card bg-c-yellow order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">DCI Match Pending</h6>
                                <h2 class="text-right">
                                    <i class="fa fa-refresh f-left"></i><span><?php echo $pendingCount; ?></span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card bg-c-green order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">DCI Match Approved</h6>
                                <h2 class="text-right">
                                    <i class="fa fa-check f-left"></i><span><?php echo $approvedCount; ?></span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card bg-c-red order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">DCI Match Rejected</h6>
                                <h2 class="text-right">
                                    <i class="fa fa-times f-left"></i><span><?php echo $rejectedCount; ?></span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card shadow-2-strong" style="background-color: #f5f7fa">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">UniSZA Subject </th>
                                                <th scope="col">Diploma Subject </th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tasks as $task): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($task['subjectA']); ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($task['subjectB']); ?>
                                                    </td>
                                                    <td class="<?php echo strtolower($task['status']); ?>">
                                                        <?php echo htmlspecialchars($task['status']); ?>
                                                    </td>
                                                    <td>
                                                        <form action="smeviewtask.php" method="POST">
                                                            <input type="hidden" name="taskId"
                                                                value="<?php echo htmlspecialchars($task['ID']); ?>">
                                                            <input type="hidden" name="subjectA"
                                                                value="<?php echo htmlspecialchars($task['subjectA']); ?>">
                                                            <input type="hidden" name="subjectB"
                                                                value="<?php echo htmlspecialchars($task['subjectB']); ?>">
                                                            <input type="hidden" name="studID"
                                                                value="<?php echo htmlspecialchars($task['studID']); ?>">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm">View</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <!-- Add more rows as needed -->
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
</body>
<script>
    function redirectToApplication() {
        window.location.href = 'smeviewtask.php';
    }
</script>

</html>