<?php
include '../config/kppauthentication.php';
include '../config/DbConfig.php';

//die($_POST['matrix']);
if (isset($_POST['matrix'])) {

    $matrix = $_POST['matrix'];
    $_SESSION['matrix'] = $matrix;

    $query = "SELECT student.*, academic.*, address.*, diploma.* 
    FROM student 
    JOIN academic ON student.matrixnumber = academic.matrixnumber 
    JOIN address ON student.matrixnumber = address.matrixnumber 
    JOIN diploma ON student.matrixnumber = diploma.matrixnumber 
    WHERE student.matrixnumber = '$matrix'";
    //die($query);

    // Executing the SQL query
    $result = mysqli_query($conn, $query);

    // Initializing an empty array to store the fetched data
    $data = array();

    // Fetching data from the result set and storing it in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata for the document -->
    <meta charset="utf-8" />
    <title>Kpp | Transfer Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <!-- Stylesheets for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../CSS/kppviewprofile.css" rel="stylesheet" />
    <!-- Links for icon fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Script for decoding emails -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Additional scripts can be added here -->
    <script type="text/javascript"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow mb-3 mx-auto">
        <!-- Navbar content -->
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Button for collapsing sidebar -->
            <div>
                <form action="kppviewcourse.php" method="POST">
                    <input type="text" value="<?php echo $_POST['matrix']; ?>" hidden id="matrix" name="matrix"
                        readonly>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-book"></i> Course Request
                    </button>
                </form>
            </div>
            <!-- Title of the page -->
            <div class="text-center h4-container">
                <h4>
                    <strong>Transfer Credit Application</strong>
                </h4>
            </div>
            <!-- Button with icon aligned to the right -->
            <div class="text-end d-lg-inline-block">


                <form action="kpphome.php">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-home"></i> Home
                    </button>
                </form>
            </div>
        </div>
        <!-- Empty div for spacing on the right side of the navbar -->
        <div></div>
    </nav>

    <!-- Container with Cards -->
    <div class="container">
        <!-- Row containing cards -->
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <!-- Card for Student's Details -->
            <div class="col mb-4">
                <!-- Student's Details Card -->
                <div class="card card-style1 border-0 custom-card">
                    <!-- Card body -->
                    <div class="card-body text-center">
                        <h3 class="mb-3">Student's Details</h3>
                        <!-- Profile Image and Content Wrapper -->
                        <div class="row justify-content-center">
                            <div class="col-auto mb-3">
                                <!-- Placeholder profile image -->
                                <img class="profile-img"
                                    src="http://localhost/FYP(CTA)/<?php echo $data[0]["picture"]; ?>"
                                    alt="Profile Picture" />

                            </div>
                            <!-- Content -->
                            <div class="col-auto">
                                <!-- List of student details -->
                                <ul class="list-unstyled text-start">
                                    <li><strong>Name:</strong>
                                        <?php echo $data[0]["fullname"]; ?>
                                    </li>
                                    <li><strong>Matrix Number:</strong> <?php echo $data[0]["matrixnumber"]; ?></li>
                                    <li><strong>IC Number: </strong><?php echo $data[0]["icnumber"]; ?></li>
                                    <li><strong>Phone Number: </strong> <?php echo $data[0]["numbphone"]; ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card for UniSZA's Academic Details -->
            <div class="col mb-4">
                <!-- UniSZA's Academic Details Card -->
                <div class="card card-style1 border-0 custom-card">
                    <!-- Card body -->
                    <div class="card-body">
                        <h3 class="text-center mb-4">UniSZA's Academic Details</h3>
                        <!-- Container for Academic Details -->
                        <div class="container text-left mx-auto">
                            <!-- List of academic details -->
                            <ul class="list-unstyled">
                                <li><strong>Admission Session: </strong> <?php echo $data[0]["adm_session"]; ?></li>
                                <li>
                                    <strong>Academic Year/Semester: </strong> <?php echo $data[0]["year_sem"]; ?>
                                </li>
                                <li>
                                    <strong>Programme: </strong><?php echo $data[0]["programme"]; ?>
                                </li>
                                <li>
                                    <strong>Faculty: </strong><?php echo $data[0]["faculty"]; ?>
                                </li>
                                <li><strong>Campus: </strong><?php echo $data[0]["campus"]; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card for Student's Address Details -->
            <div class="col mb-4">
                <!-- Student's Address Details Card -->
                <div class="card card-style1 border-0 custom-card">
                    <!-- Card body -->
                    <div class="card-body">
                        <h3 class="text-center mb-4">Student's Address Details</h3>
                        <!-- Container for Address Details -->
                        <div class="container text-left mx-auto">
                            <!-- List of address details -->
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Permanent Address: </strong> <?php echo $data[0]["permanent"]; ?>
                                </li>
                                <li>
                                    <strong>Current Address: </strong> <?php echo $data[0]["current"]; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card for Previous Academic Details -->
            <div class="col mb-4">
                <!-- Previous Academic Details Card -->
                <div class="card card-style1 border-0 custom-card">
                    <!-- Card body -->
                    <div class="card-body">
                        <h3 class="text-center mb-4">Previous Academic Details</h3>
                        <!-- Container for Previous Academic Details -->
                        <div class="container text-left mx-auto">
                            <!-- List of previous academic details -->
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Previous Institution Name:</strong> <?php echo $data[0]["prev_inst"]; ?>
                                </li>
                                <li>
                                    <strong>Previous Programme: </strong> <?php echo $data[0]["prev_prog"]; ?>
                                </li>
                                <?php
                                // Set the base directory where your files are located
                                $base_directory = 'http://localhost/FYP(CTA)/uploads/transcript/';
                                // Concatenate the base directory with the file name
                                $file_url = $base_directory . basename($data[0]["file"]);
                                ?>
                                <li>
                                    <strong>Previous Academic Transcript: </strong>
                                    <a href="<?php echo $file_url; ?>" target="_blank">
                                        <?php echo basename($data[0]["file"]); ?>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Card Hover Effect -->
    <script>
        // Get all card elements
        const cards = document.querySelectorAll(".card");

        // Add event listener to each card
        cards.forEach((card) => {
            // Add mouseenter event listener
            card.addEventListener("mouseenter", function () {
                // Add a class to apply hover effect when mouse enters the card
                this.classList.add("card-hover");
            });

            // Add mouseleave event listener
            card.addEventListener("mouseleave", function () {
                // Remove the class to remove hover effect when mouse leaves the card
                this.classList.remove("card-hover");
            });
        });

    </script>
</body>

</html>