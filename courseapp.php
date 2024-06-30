<?php include 'config/authentication.php';
include 'config/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="images/Tab_Icon.png" />
    <title>Course Application | ECTH</title>
    <link rel="stylesheet" href="CSS/courseapp.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/courseapp.js"></script>
</head>

<body>
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

        echo '<div class="alert ' . $bootstrap_class . ' alert-dismissible fade show">';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">';
        echo '</button>';
        echo $_SESSION['response_text'];
        echo '</div>';

        $_SESSION['response_type'] = '';
        $_SESSION['response_text'] = '';

    }
    ?>


    <form action="courseappprocess.php" method="post" enctype="multipart/form-data" id="submitForm">
        <div class="wrapper rounded bg-white">
            <!-- First Table Group -->
            <div class="table-group">
                <div class="h3">Degree Course in UniSZA</div>
                <div class="form">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Credit Hour</th>
                            </tr>
                        </thead>
                        <tbody id="degTableBody">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="uniszacoursecode[]"
                                        placeholder="e.g., CSF 11603" required />
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="uniszacoursename[]"
                                        placeholder="e.g., Discrete Mathematics" required />
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="uniszacredithour[]"
                                        placeholder="e.g., 3" required />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Second Table Group -->
            <div class="table-group">
                <div class="h3">Diploma Course in
                    <?php if (isset($_SESSION['prev_inst'])) {
                        echo $_SESSION['prev_inst'];
                    } else {
                        echo "";
                    } ?>
                </div>
                <div class="form">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Credit Hour</th>
                                <th>Grade</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody id="dipTableBody">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="dipcoursecode[]"
                                        placeholder="e.g., CSF 11603" required />
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="dipcoursename[]"
                                        placeholder="e.g., Discrete Mathematics" required />
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="dipcredithour[]"
                                        placeholder="e.g., 3 " required />
                                </td>
                                <td>
                                    <select class="form-select" name="dipgrade[]">
                                        <option value="A+">A+</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="B-">B-</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="dipfile[]" accept=".pdf" multiple
                                            required />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="button" class="btn btn-success mt-3" id="addRowBtn" data-bs-target="#confirmationModal">
                Add Course
            </button>

            <button type="button" class="btn btn-danger mt-3" id="removeRowBtn">
                Remove Course
            </button>

            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                data-bs-target="#confirmationModal" id="showConfirmationModal">
                Transfer
            </button>

            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">
                                Confirm Course Transfer
                            </h5>
                        </div>
                        <div class="modal-body">
                            Is this your only transfer request?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success" name="submit" id="confirmSubmit">
                                Yes, Transfer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="warningaddModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="warningaddModalLabel">
                                Warning
                            </h5>
                        </div>
                        <div class="modal-body">
                            Maximum limit of 15 rows reached.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Okay
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="warningremoveModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="warningremoveModalLabel">
                                Warning
                            </h5>
                        </div>
                        <div class="modal-body">
                            A minimum of one row in both the diploma and degree is requisite.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Okay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>