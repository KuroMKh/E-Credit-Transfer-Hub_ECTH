<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="x-icon" href="images/Tab_Icon.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background: #ececec;
    }

    .bg-custom {
      background-color: #103cbe !important;
    }

    .custom-icon {
      font-size: 1.5rem;
      color: white;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-custom p-3">
    <div class="container-fluid">
      <a class="navbar-brand" href="home.php"><img src="images/navicon.png" alt="" width="30" height="30"> E-Credit
        Transfer
        Hub (ECTH) </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation" class="d-inline-block align-text-top>
            <span class=" navbar-toggler-icon"></span>
      </button>
      <div class=" collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <a class="nav-link mx-2" aria-current="page" href="home.php">Application Status</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2" aria-current="page" href="studentprofileprocess.php">Student Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2" href="studinfo.php">Student Information</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2" href="courseapp.php">Course Application</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn" href="logout.php">
              <i class="bi bi-door-open custom-icon"></i>
            </a>
          </li>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>

</html>