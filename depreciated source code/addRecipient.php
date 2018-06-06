<?php
  require('sessionValidator.php');

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

    <title>Add New Recipient</title>
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
  <?php require_once('config.php');?>

   <?php include("userComponents/navbar.php"); ?>
    <div class="container">
      <div class="row justify-content-center"> <!-- Makes page content a little more centered now -->
        <?php include("userComponents/sidebar.php"); ?>
        <div class ="col-sm-12 page-content">
          <div class="container">
            <div class="row" style="padding:50px 0px">
              <div class="col">
                <h3>Add Recipient</h3>
                  </div>
                </div>
              </div>

        <div class="container">
          <div class="card">
            <div class="card-header">Add a new recipient</div>
            <div class="card-body">
              <form action="postRecip.php" method="post" id="addRecip" novalidate>
                <div class="form-row">
                  <div class="form-group col-sm">
                    <label for="f_name">Recipient's First Name:</label>
                    <input  class="form-control"
                            type="text"
                            id="f_name"
                            name="f_name"
                            required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback">Please enter a first name</div>
                  </div>
                  <div class="form-group col-sm">
                    <label for="l_name">Recipient's Last Name:</label>
                    <input  class="form-control"
                            type="text"
                            id="l_name"
                            name="l_name"
                            required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback">Please enter a last name</div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-sm">
                    <label for="email">Recipient's Email:</label>
                    <input  class="form-control"
                            type="email"
                            id="email"
                            name="email"
                            value="<?php echo $_SESSION['recipE'] ?>"
                            required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback invalid-feedback-email">
                    Please provide a valid email address</div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-sm">
                    <label for="branch">Select Recipient's Branch:</label>
                    <?php
                    $query = "SELECT id, name FROM branch";
                    $result = mysqli_query($dbc, $query);
                    ?>
                    <select class="form-control" id="branch" name="branch">
                      <?php while($row = mysqli_fetch_assoc($result)){
                        echo "<option value='" .$row['id'] ."' >" .$row['name'] ."</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-sm">
                    <label for="manager">Select Recipient's Manager:</label>
                    <?php
                    $query = "SELECT id, f_name, l_name FROM manager";
                    $result = mysqli_query($dbc, $query);
                    ?>
                    <select class="form-control" id="manager" name="manager">
                      <?php while($row = mysqli_fetch_assoc($result)){
                        echo "<option value='" .$row['id'] ."' >" .$row['f_name'] ." " .$row['l_name'] ."</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-sm">
                    <label for="job_title">Recipient's Job Title:</label>
                    <input  class="form-control"
                            type="text"
                            id="job_title"
                            name="job_title"
                            required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback">Please enter a job title</div>
                  </div>
                  <div class="form-group col=sm">
                    <label for="salary">Recipient's Salary:</label>
                    <input  class="form-control"
                            type="number"
                            id="salary"
                            name="salary"
                            min="1"
                            required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback">Please enter a salary</div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-sm">
                    <label for="hire_date">Recipient's Hire Date:</label>
                    <input  class="form-control"
                            type="date"
                            id="hire_date"
                            name="hire_date"
                            required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback">Please enter a hire date</div>
                  </div>
                </div>
                <button type="submit" id="subButt" class="btn btn-primary">Submit Recipient</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Custom JavaScript -->
  <script>
      $("#addRecipbtn").addClass("active");
  </script>
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
    $('#hire_date').attr("max", today);
    });
  </script>
  <script type="text/javascript" src="userScripts/verifySubmission.js"></script>

</body>
