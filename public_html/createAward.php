<?php
  require('sessionValidator.php');
  $_SESSION['location'] = 0;

  // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
  // URL directly. The code below will end the session of an admin user who tries to gain access.
  if($_SESSION['accountType'] == "admin"){
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Create Award</title>
    <!-- Required meta tags for Bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles/custom.css">

</head>

<body>

  <?php
    session_start();
    require_once('config.php');

    $my_array = array("Employee of The Month", 
      "Employee of The Year", 
      "Employee of The Week", 
      "Best Dressed",
      "Awesome Teammate");

    $key = $_SESSION["recipE"];
    $query = "SELECT email, f_name, l_name FROM recipient WHERE email LIKE '" . $key . "'";
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_assoc($result);
  ?>

   <?php include("userComponents/navbar.php"); ?>
    <div class="container">
      <div class="row justify-content-center"> <!-- Makes page content a little more centered now -->
        <?php include("userComponents/sidebar.php"); ?>
        <div class ="col-sm-12 page-content">
          <div class="container">
            <div class="row" style="padding:50px 0px">
              <div class="col">
                <h3>Create Award</h3>
              </div>
            </div>
          </div>

            <div class="container">
              <div class="card">
                <div class="card-header">Create an award</div>
                <div class="card-body">
                  <form action="postAward.php" method="post">
                    <div class="form-row">
                      <div class="form-group col-sm">
                        <label for="typeAward">Type of Award:</label>
                        <select class="form-control" id="typeAward" name="typeAward">
                            <?php foreach($my_array as $item) { ?>
                              <option value="<?php echo $item; ?>"><?php echo $item; ?> </option>
                            <?php }?>
                        </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm">
                        <label for="timeAward">Time of Award:</label>
                        <input class="form-control" type="time" id="timeAward" name="timeAward" required>
                      </div>
                      <div class="form-group col-sm">
                        <label for="dateAward">Date of Award:</label>
                        <input class="form-control" 
                              type="date" 
                              id="dateAward" 
                              name="dateAward"
                              max='2020-1-1' 
                              required>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm">
                        <label for="recipEmail">Recipient's Email:</label>
                        <input class="form-control" 
                              type="text" 
                              id="recipEmail" 
                              name="recipEmail" 
                              value="<?php echo $row['email']; ?>"
                              readonly>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm">
                        <label for="recipFName">Recipient's First Name:</label>
                        <input class="form-control" 
                              type="text" 
                              id="recipFName" 
                              name="recipFName" 
                              value="<?php echo $row['f_name'] ?>" 
                              readonly>
                      </div>
                      <div class="form-group col-sm">
                        <label for="recipLName">Recipient's Last Name:</label>
                        <input class="form-control"
                              type="text"
                              id="recipLName"
                              name="recipLName"
                              value="<?php echo $row['l_name'] ?>"
                              readonly>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit Award</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  <?php mysqli_close($dbc); 
  unset($_SESSION["recipE"]);?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();

    if(dd < 10){
      dd = '0' + dd
    }
    if(mm < 10){
      mm='0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;
    $('#dateAward').attr("max", today);
    });
  </script>
<script>
    $("#searchEmailbtn").addClass("active");
</script>
</body>
