<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="x-icon" href="images/Tab_Icon.png">
  <title>ECTH</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link href="CSS/index.css" rel="stylesheet" />
</head>

<body>
  <header style="background-color: rgb(0, 91, 228);" class="text-white py-2">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="logo"><img src="images/navicon.png" alt="" width="42" height="42"> E-Credit Transfer Hub (ECTH)</h2>
      </div>
    </div>
  </header>
  <div class="container py-5">
    <h1 class="text-center">Please Login</h1>
    <p class="text-center">Select your category to continue</p>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 py-5">
      <!-- Adjusted the column classes for different screen sizes -->
      <div class="col">
        <div class="card" onclick="location.href='studentlogin.php';" style="cursor: pointer;">
          <img src="images/students.jpg" class="card-img-top" alt="Student" />
          <div class="card-body text-center">
            <h5 class="card-title"><strong>STUDENT</strong></h5>
            <p class="card-text">
              Faculty of Informatics and Computing
              <br>Restricted to Student Only
            </p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card" onclick="location.href='kpp/kpplogin.php';" style="cursor: pointer;">
          <img src="images/kpp.jpg" class="card-img-top" alt="KPP" />
          <div class="card-body text-center">
            <h5 class="card-title"><strong>KPP</strong></h5>
            <p class="card-text">
              Faculty of Informatics and Computing
              <br>Restricted to Kpp Only
            </p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card" onclick="location.href='sme/smelogin.php';" style="cursor: pointer;">
          <img src="images/sme.jpg" class="card-img-top" alt="SME" />
          <div class="card-body text-center">
            <h5 class="card-title"><strong>SME</strong></h5>
            <p class="card-text">
              Faculty of Informatics and Computing
              <br>Restricted to SME Only
            </p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card" onclick="location.href='admin/adminlogin.php';" style="cursor: pointer;">
          <img src="images/admin_1.jpg" class="card-img-top" alt="SME" />
          <div class="card-body text-center">
            <h5 class="card-title"><strong>ADMIN</strong></h5>
            <p class="card-text">
              Faculty of Informatics and Computing
              <br>Restricted to Admin Only
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script>
    // JavaScript for hover animation
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
      card.addEventListener('mouseenter', () => {
        card.style.transform = 'scale(1.05)';
        card.style.transition = 'transform 0.3s ease';
      });

      card.addEventListener('mouseleave', () => {
        card.style.transform = 'scale(1)';
        card.style.transition = 'transform 0.3s ease';
      });
    });
  </script>
</body>

</html>