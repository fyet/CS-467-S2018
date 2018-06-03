<!DOCTYPE html>
<?php require '../sessionValidator.php';?>
<html lang="en">
<head>
  <title>Manage Users</title>
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
  <!-- *************************************************************************
                              top horizontal navbar
  ************************************************************************** -->
  <?php include("components/navbar.php"); ?>
  <!-- Sidebar and page content wrappers -->
  <div class="container-fluid">
    <div class="row">
      <!-- *********************************************************************
                                  responsive sidebar
      ********************************************************************** -->
      <?php include("components/sidebar.php"); ?>
      <!-- *********************************************************************
                                    page content
      ********************************************************************** -->
      <div class="col-sm-12 page-content">
        <!-- add new user button -->
        <div class="row">
          <div class="col-xl">
            <div class="float-right">
              <button type="button"
                      class="btn btn-primary btn-md active"
                      float="right"
                      data-toggle="modal"
                      data-target="#addUserModal">
                + Add New User
              </button>
            </div>
          </div>
        </div>
        <!-- database-generated users table -->
        <div class="row">
          <div class="col-xl">
            <p class="h3">AwardHub Users</p>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email address</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody id="usersTable">
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- end users table -->
      </div>
    </div>
  </div> <!-- End sidebar and page content -->
  <!-- *************************************************************************
                                Add new user modal
  ************************************************************************** -->
  <div  class="modal fade" id="addUserModal"
        tabindex="-1" role="dialog"
        aria-labelledby="addUserModal"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalTitle">Add New User</h5>
          <button type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addUserForm" novalidate>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="userFirstName">First name</label>
                <input  type="text"
                        class="form-control"
                        id="firstNameNew"
                        aria-describedby="firstNameHelp"
                        placeholder="Enter first name"
                        required>
                <div class="valid-feedback">Good to go!</div>
                <div class="invalid-feedback">Please enter a first name</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="userLastNameNew">Last name</label>
                <input  type="text"
                        class="form-control"
                        id="lastNameNew"
                        aria-describedby="lastNameHelp"
                        placeholder="Enter last name"
                        required>
                <div class="valid-feedback">Good to go!</div>
                <div class="invalid-feedback">Please enter a last name</div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12">
                <label for="userEmail">Email address</label>
                <input  type="email"
                        class="form-control"
                        id="userEmailNew"
                        aria-describedby="emailHelp"
                        placeholder="Enter email"
                        required>
                <div class="valid-feedback">
                  Good to go!
                </div>
                <div class="invalid-feedback invalid-feedback-email">
                  Please provide a valid email address
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
            Exit without saving changes
          </button>
          <button id="submitNewUser" type="button" class="btn btn-primary btn-sm">
            Submit new user
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- *************************************************************************
                                Edit user modal
  ************************************************************************** -->
  <div  class="modal fade" id="editUserModal"
        tabindex="-1" role="dialog"
        aria-labelledby="editUserModal"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalTitle">Edit Existing User Account</h5>
          <button type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editUserForm" novalidate>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="userFirstName">First name</label>
                <input  type="text"
                        class="form-control is-valid"
                        id="userFirstNameToEdit"
                        aria-describedby="firstNameHelp"
                        placeholder="Enter first name"
                        required>
                <div class="valid-feedback">Good to go!</div>
                <div class="invalid-feedback">Please enter a first name</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="userLastName">Last name</label>
                <input  type="text"
                        class="form-control is-valid"
                        id="userLastNameToEdit"
                        aria-describedby="lastNameHelp"
                        placeholder="Enter last name"
                        required>
                <div class="valid-feedback">Good to go!</div>
                <div class="invalid-feedback">Please enter a last name</div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12">
                <label for="userEmail">Email address</label>
                <input  type="email"
                        class="form-control is-valid"
                        id="userEmailToEdit"
                        aria-describedby="emailHelp"
                        placeholder="Enter email"
                        required>
                <div class="valid-feedback">
                  Good to go!
                </div>
                <div class="invalid-feedback invalid-feedback-email">
                  Please provide a valid email address
                </div>
              </div>
            </div>
            <input id="userIDtoEdit" style="visibility: hidden;">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
            Exit without saving changes
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="submitEdit">
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- *************************************************************************
                                Delete user modal
  ************************************************************************** -->
  <div  class="modal fade" id="deleteUserModal"
        tabindex="-1" role="dialog"
        aria-labelledby="deleteUserModal"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteUserModalTitle">Delete Existing User Account</h5>
          <!-- top-right-corner X -->
          <button type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <p>You have selected to permanently delete the AwardHub user account of:</p>
          <h4>example@email.com</h4>
          <p>Are you sure you want to delete this account?</p>
          <input id="userIDtoDelete" style="visibility: hidden;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
            No, exit without saving changes
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="submitUserDelete">
            Yes, delete the selected account
          </button>
        </div>
      </div>
    </div>
  </div>
  <?php include('components/passwordModal.php'); ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- add custom scripts below -->
  <script>
    $("#manageUsersBtn").addClass("active"); //add active class to manage users button
  </script>
  <script type="text/javascript" src="scripts/manageUsers.js"></script>
  <script type="text/javascript" src="scripts/changePassword.js"></script>
</body>
</html>
