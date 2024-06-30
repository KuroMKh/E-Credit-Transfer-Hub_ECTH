<?php include 'config/authentication.php';  ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="CSS/logout.css" />
    <link rel="icon" type="x-icon" href="images/Tab_Icon.png" />
    <title>Logging Out? | ECTH</title>
  </head>
  <body>
    <div class="container">
      <div class="title">Logout Confirmation</div>
      <div class="content">
        <div class="icon-container">
          <img src="images/logoutIcon.png" alt="Your Icon" />
        </div>
        <div class="confirmation-message">Are you sure you want to logout?</div>
        <form action="config/logoutconfig.php" method="post">
          <div class="button">
            <button type="submit" name="yes">Yes</button>
            <button type="submit" name="no">No</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
