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

<!doctype html>
<html lang="en">
<head>
    <title>User Home</title>
    <!-- Required meta tags for Bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles/custom.css">

</head>
<body>
    <?php
    session_start();
    require_once('../database-resources/config.php');
    $_SESSION['location'] = 0;
    ?>

    <?php include("userComponents/navbar.php"); ?>
    <div class="container-fluid">
        <div class="row">
            <?php include("userComponents/sidebar.php"); ?>



            <div class ="col-sm-12 page-content">
                <div class="row" style="padding:50px 0px">
                    <div class="col-xl">
                            <p class="h3">Edit Recipient</p>
                    </div>
                    <div class="table-responsive">
                            <table class="table table-hover" id="userTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Branch</th>
                                        <th scope="col">Manager</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Salary</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="recipTable">
                                </tbody>
                            </table>

            </div>
        </div>
    </div>
<div class="modal fade" id="editRecipient"
    tabindex="-1" role="dialog"
    aria-labelledby="editRecipient"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal title" id="editRecipientTitle">Editing Recipient Account</h5>
                <button type="button"
                        clas="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editRecipForm" novalidate>
                <div class="form-row">
                  <div class="form-group col-sm">
                    <label for="f_name">Recipient's First Name:</label>
                    <input class="form-control is-valid"
                    type="text"
                    id="f_nameEdit"
                    aria-describedby="firstNameHelp"
                    required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback">Please enter a first name</div>
                  </div>
                  <div class="form-group col-sm">
                    <label for="l_name">Recipient's Last Name:</label>
                    <input class="form-control is-valid"
                    type="text"
                    id="l_nameEdit"
                    aria-describedby="lastNameHelp"
                    required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback">Please enter a last name</div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-sm">
                    <label for="email">Recipient's Email:</label>
                    <input class="form-control is-valid"
                    type="email"
                    id="emailEdit"
                    aria-describedby="emailHelp"
                    required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback invalid-feedback-email">Please provide a valid email address</div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-sm">
                    <label for="branch">Select Recipient's Branch:</label>
                    <?php
                    $query = "SELECT id, name FROM branch";
                    $result = mysqli_query($dbc, $query);
                    ?>
                    <select class="form-control" id="branchEdit">
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
                    <select class="form-control" id="managerEdit">
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
                    <input class="form-control is-valid"
                    type="text"
                    id="job_titleEdit"
                    aria-describedby="jobTitleHelp"
                    required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback">Please enter a job title</div>
                  </div>
                  <div class="form-group col=sm">
                    <label for="salary">Recipient's Salary:</label>
                    <input class="form-control is-valid"
                    type="number"
                    id="salaryEdit"
                    aria-describedby="salaryHelp"
                    min="1"
                    required>
                    <div class="valid-feedback">Looks Good!</div>
                    <div class="invalid-feedback">Please enter a salary</div>
                  </div>
                </div>
                <input id="userIDEdit" style="visibility: hidden;">
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                Cancel
            </button>
            <button type="button" class="btn btn-primary btn-sm" id="subEdit">
                Update
            </button>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="deleteRecipModal"
    tabindex="-1" role="dialog"
    aria-labelledby="deleteUserModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRecipModalTitle">Delete Existing Recipient</h5>
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete this recipient?</p>
                <input id="recipIdDelete" style="visibility: hidden;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm " data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="subDel">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript" src="./userScripts/manageRecip.js"></script>
<script>
    $("#editRecipbtn").addClass("active");
</script>
</body>
