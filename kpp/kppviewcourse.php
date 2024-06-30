<?php
include '../config/kppauthentication.php';
include '../config/DbConfig.php';

if (isset($_POST['matrix'])) {
    $matrix = $_POST['matrix'];
    $_SESSION['matrix'] = $matrix;

    $query = "SELECT DISTINCT 
    d.uniszacoursecode AS degree_uniszacoursecode,
    d.uniszacoursename AS degree_uniszacoursename,
    d.uniszacredithour AS degree_uniszacredithour,
    dip.dipcoursecode AS diploma_dipcoursecode,
    dip.dipcoursename AS diploma_dipcoursename,
    dip.dipcredithour AS diploma_dipcredithour,
    dip.dipgrade AS diploma_dipgrade,
    dip.dipfile AS diploma_dipfile,
    CASE 
        WHEN s.status IS NOT NULL THEN s.status
        ELSE 'PENDING'
    END AS degree_status
FROM 
    degcourse d
LEFT JOIN 
    dipcourse dip ON d.id = dip.id
LEFT JOIN
    similarity s ON d.uniszacoursecode = s.subjectA AND dip.dipcoursecode = s.subjectB
WHERE 
    d.matrixnumber = '" . $matrix . "'";
    $result = mysqli_query($conn, $query);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    $query2 = "SELECT prev_inst, prev_prog FROM diploma WHERE matrixnumber = '" . $matrix . "'";

    // Executing the second SQL query
    $result2 = mysqli_query($conn, $query2);

    $data2 = array();
    while ($row = mysqli_fetch_assoc($result2)) {
        $data2[] = $row;
    }

    // Fetch prev_inst from data2 array &  Encode prev_inst value for URL
    $prevInst = isset($data2[0]['prev_inst']) ? $data2[0]['prev_inst'] : '';
    $prevInstEncoded = urlencode($prevInst);

    $prevProg = isset($data2[0]['prev_prog']) ? $data2[0]['prev_prog'] : '';
    $prevProgEncoded = urlencode($prevProg);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Kpp | Transfer Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../CSS/kppviewcourse.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow mb-3 mx-auto">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <form action="kpphome.php">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-home"></i> Home
                    </button>
                </form>
            </div>
            <div class="text-center h4-container">
                <h4>
                    <strong>Transfer Credit Application</strong>
                </h4>
            </div>
            <div class="text-end d-lg-inline-block">
                <form action="kppviewprofile.php" method="POST">
                    <input type="text" value="<?php echo $_POST['matrix']; ?>" hidden id="matrix" name="matrix"
                        readonly>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-graduation-cap"></i> Student Profile
                    </button>
                </form>
            </div>
        </div>
        <div></div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header" style="background-color: #002d72; color: white;">
                <h6 class="card-title mb-0"><strong>Requested Course Transfers</strong></h6>
            </div>
            <div class="card-body">
                <form action="kppapplicationprocess.php" method="post">
                    <input type="text" value="<?php echo $_POST['matrix']; ?>" hidden id="matrixnumb" name="matrixnumb"
                        readonly>
                    <div class="table-responsive" style="max-height: 1000px; overflow-y: auto;">
                        <table class=" table table-bordered">
                            <thead style="background-color: #002d72; color: white;">
                                <tr>
                                    <th class="course-code-column">UniSZA Course Code</th>
                                    <th class="course-name-column">UniSZA Course Name</th>
                                    <th class="credit-hour-column">UniSZA Credit Hour</th>
                                    <th class="course-code-column">Previous Institution Course
                                        Code</th>
                                    <th class="course-name-column">Previous Institution Course Name</th>
                                    <th class="credit-hour-column">Previous Institution Credit Hour</th>
                                    <th class="grade-column">Previous Institution Grade</th>
                                    <th class="file-column">Previous Institution Course DCI</th>
                                    <th class="narrow-column">Syllabus Overlap %</th>
                                    <th class="narrow-column">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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
                                    if (isset($row['diploma_dipfile'])) {
                                        echo '<a href="../' . htmlspecialchars($row['diploma_dipfile']) . '" target="_blank" class="btn btn-primary view-file" data-file-path="' . htmlspecialchars($row['diploma_dipfile']) . '">';
                                        echo '<i class="fa fa-search"></i> View';
                                        echo '</a>';
                                    }
                                    echo '</td>';

                                    echo '<td class="narrow-column">';

                                    $query2 = "SELECT similaritypercent
                                    FROM similarity
                                    WHERE subjectA = '" . $row['degree_uniszacoursecode'] . "' AND subjectB = '" . $row['diploma_dipcoursecode'] . "'";
                                    $result2 = mysqli_query($conn, $query2);

                                    $data2 = array();
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        $data2[] = $row2;
                                    }

                                    if (isset($data2[0])) {
                                        if ($data2[0]['similaritypercent'] == null)
                                            echo "In progress";
                                        else
                                            echo $data2[0]['similaritypercent'] . '%';
                                    } else {
                                        // Check if subjects exist in the table but no similarity data
                                        $query3 = "SELECT * FROM similarity WHERE subjectA = '" . $row['degree_uniszacoursecode'] . "'";
                                        $result3 = mysqli_query($conn, $query3);

                                        $subjectBExists = false;
                                        while ($row3 = mysqli_fetch_assoc($result3)) {
                                            if ($row3['subjectB'] == $row['diploma_dipcoursecode']) {
                                                $subjectBExists = true;
                                                break;
                                            }
                                        }

                                        if ($subjectBExists) {
                                            echo "In Progress";
                                        } else {
                                            $degcoursecode = urlencode($row['degree_uniszacoursecode']);
                                            $degcoursename = urlencode($row['degree_uniszacoursename']);
                                            $degcredithour = urlencode($row['degree_uniszacredithour']);
                                            $dipcoursecode = urlencode($row['diploma_dipcoursecode']);
                                            $dipcoursename = urlencode($row['diploma_dipcoursename']);
                                            $dipcredithour = urlencode($row['diploma_dipcredithour']);
                                            $dipfile = urlencode($row['diploma_dipfile']);
                                            $matrix_encoded = urlencode($matrix);

                                            $url = "kppassigntask.php?degcoursecode=$degcoursecode&degcoursename=$degcoursename&degcredithour=$degcredithour&dipcoursecode=$dipcoursecode&dipcoursename=$dipcoursename&dipcredithour=$dipcredithour&dipfile=$dipfile&matrix=$matrix_encoded&prevInst=$prevInstEncoded&prevProg=$prevProgEncoded";

                                            echo '<form action="kppassigntask.php" method="post" style="display: inline;">';
                                            echo '<input type="hidden" value="' . htmlspecialchars($matrix) . '" name="matrix" readonly>';
                                            echo '<input type="hidden" value="' . htmlspecialchars($prevInstEncoded) . '" name="prevInst" readonly>';
                                            echo '<input type="hidden" value="' . htmlspecialchars($prevProgEncoded) . '" name="prevProg" readonly>';
                                            echo '<a href="' . $url . '" class="btn btn-warning">';
                                            echo '<i class="fas fa-clipboard text-white"></i> <span style="color: white;">Task</span>';
                                            echo '</a>';
                                            echo '</form>';
                                        }
                                    }

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
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal">
                            <i class="fas fa-save text-white"></i> <span style="color: white;"> Update
                                Application</span>
                        </button>
                    </div>
                    <input type="hidden" name="update_status" value="1">

                    <!-- Modal for confirmation -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1"
                        aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered"> <!-- Added modal-dialog-centered class -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to update the application?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        $('.view-file').click(function () {
            var filePath = $(this).data('file-path');
            if (filePath) {
                window.open(filePath, '_blank');
            } else {
                alert("File path is not available.");
            }
        });

        $(document).ready(function () {
            // Show confirmation modal before form submission
            $('form').submit(function (event) {
                event.preventDefault(); // Prevent default form submission
                $('#confirmationModal').modal('show');
            });

            // Handle confirm button click in modal
            $('#confirmUpdate').click(function () {
                $('#confirmationModal').modal('hide'); // Hide modal
                $('form').unbind('submit').submit(); // Proceed with form submission
            });
        });
    </script>
</body>

</html>