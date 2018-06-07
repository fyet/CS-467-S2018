<?php
  require('../login-system/sessionValidator.php');
  $_SESSION['location'] = 0;

  // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
  // URL directly. The code below will end the session of an admin user who tries to gain access.
  if($_SESSION['accountType'] == "admin"){
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
  }
?>

<!doctype html>
<html lang="en">
<head>
    <title>My Account</title>
    <!-- Required meta tags for Bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles/custom.css">
    <link rel="stylesheet" href="css/signature-pad.css">

    <style>

    .list-group{
        z-index:10;display:none;
        position:absolute;
        color:red;
    }
    .msg
    {
        position:absolute;
        color:red;
    }
    </style>
</head>
<body>
  <?php require_once('../database-resources/config.php');
  session_start();?>

   <?php include("userComponents/navbar.php"); ?>
    <div class="container">
        <div class="row justify-content-center"> <!-- Makes page content a little more centered now -->
            <?php include("userComponents/sidebar.php"); ?>
            <div class ="col-sm-12 page-content">
                <div class="container">
                  <div class="row" style="padding:50px 0px">
                    <div class="col">
                      <h3>Edit My Account</h3>
                    </div>
                  </div>
                </div>

                <div class ="container">
                    <div class ="card">
                        <div class="card-header">Edit First or Last Name:</div>
                        <div class="card-body">
                            <form action="editName.php" method="post">
                                <div class="form-row">
                                    <div class="form-group col-sm">
                                        <?php
                                        $user = $_SESSION['user'];
                                        $query = "SELECT f_name, l_name FROM user WHERE id=" .$user;
                                        $result = mysqli_query($dbc, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        ?>
                                        <label for="f_name">First Name:</label>
                                        <input class="form-control"
                                        type="text"
                                        id="f_name"
                                        name="f_name"
                                        value="<?php echo $row['f_name'] ?>"
                                        required>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label for="l_name">Last Name:</label>
                                        <input class="form-control"
                                        type="text"
                                        id="l_name"
                                        name="l_name"
                                        value="<?php echo $row['l_name'] ?>"
                                        required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="container mt-4">
                    <div class="card">
                        <div class="card-header">Change Password:</div>
                        <div class="card-body">
                          <form action="editPsword.php" method="post">
                              <div class="form-row">
                                <div class="form-group col-sm-6">
                                  <label for="psword">New Password:</label>
                                  <input class="form-control"
                                      id="pword"
                                      type="password"
                                      name="psword">
                                <!-- I don't know what this stuff does so I've commented it out
                                <br><br>
                                <div id="display_box" class="msg"></div>-->
                                </div>
                                <div class="form-group col-sm-6">
                                  <ul id="d1" class="list-group">
                                    <li class="list-group-item list-group-item-success">Password Conditions</li>
                                    <li class="list-group-item" id="d2">One Upper Case Letter</li>
                                    <li class="list-group-item" id="d3">One Lower Case Letter</li>
                                    <li class="list-group-item" id="d4">One Number</li>
                                    <li class="list-group-item" id="d5">At Least 8 Characters</li>
                                  </ul>
                                </div>
                              </div>
                              <button type="submit" class="btn btn-primary" id="pwButton" disabled>Submit Password</button>
                          </form>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="card mt-4">
                        <!-- Code below derived from https://github.com/szimek/signature_pad/blob/master/docs/index.html -->
                        <div class="card-header">Change Signature:</div>
                        <div class="card-body">
                            <div id="signature-pad" class="signature-pad">
                                <div class="signature-pad--body">
                                    <canvas height="75" width="300"></canvas>
                                </div>
                                <div class="signature-pad--footer">
                                    <div class="description">Sign above with your mouse or upload a 'png' file of your signature below</div>
                                    </div>
                                </div>
                                <br>

                                <form action='/postSig.php' method="post" name="form1" id="form1" enctype="multipart/form-data">
                                    <input type="hidden" name="my_hidden" id="my_hidden"/>
                                    <span>Note: Server will automatically resize image for best fit with certificates. Only 'png' files will be saved.</span><br>
                                    <input type="file" name="file"/><br><br><br>
                                    <input type="submit" id="submitBtn" value="Submit"/>
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
<script src="/node_modules/signature_pad/example/js/signature_pad.js"></script>
<script src="/userScripts/sigDriver.js"></script>
<script>
    $("#manageUserbtn").addClass("active");
</script>
<script>
    $(document).ready(function(){
        $('#pword').keyup(function(){
            var str = $('#pword').val();
            var upper_let = new RegExp('[A-Z]');
            var lower_let = new RegExp('[a-z]');
            var num_pres = new RegExp('[0-9]');

            var flag='T';

            if(str.match(upper_let)){
                $('#d2').css("color", "green");
            }
            else{
                $('#d2').css("color", "red");
                flag='F';
            }

            if(str.match(lower_let)){
              $('#d3').css("color", "green");
            }
            else{
              $('#d3').css("color", "red");
              flag='F';
            }

            if(str.match(num_pres)){
              $('#d4').css("color", "green");
            }
            else{
              $('#d4').css("color", "red");
              flag='F';
            }

            if(str.length>7){
              $('#d5').css("color", "green");
            }
            else{
              $('#d5').css("color", "red");
              flag='F';
            }

            if(flag == 'T'){
              $('#d1').fadeOut();
              $('#display_box').css("color", "green");
              $('#pwButton').prop('disabled', false);
            }
            else{
              $('#d1').show();
              $('#display_box').css("color", "green");
              $('#pwButton').prop('disabled', true);
            }

        });

        $('#pword').blur(function(){
            $('#d1').fadeOut();
        });

        $('#pword').focus(function(){
            $('#d1').show();
        });
    });
</script>
</body>
