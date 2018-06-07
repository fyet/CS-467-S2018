<?php
  require('../login-system/sessionValidator.php');

  // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
  // URL directly. The code below will end the session of an admin user who tries to gain access.
  if($_SESSION['accountType'] == "admin"){
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Search For Eployee Email</title>
    <!-- Meta Tags for Bootstrap -->
    <meta charset="utf-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Import/Include Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">


    <link rel="stylesheet" href="../styles/custom.css">

</head>

<body>
    <?php include("userComponents/navbar.php"); 
    session_start();
    $_SESSION['location'] = 1;?>

    <div class="container">
        <div class="row justify-content-center"> <!-- Makes page content a little more centered now -->
            <?php include("userComponents/sidebar.php"); ?>
            <div class ="col-sm-12 page-content">
                <div class="container">
                  <div class="row" style="padding:50px 0px">
                    <div class="col">
                      <h3>Search Recipients</h3>
                    </div>
                  </div>
                </div>

                <div class="container">
                    <div class="card">
                        <div class="card-header">Search for a recipient</div>
                        <div class="card-body">
                            <form action="search.php" method="post">
                                <div class="form-group">
                                    <input type="text" name="key" class="form-control form-control-lg" placeholder="Enter Email">
                                </div>
                                    <button type="submit" class="btn btn-primary btn-lg">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
    $("#searchEmailbtn").addClass("active");
</script>
</body>
</html>