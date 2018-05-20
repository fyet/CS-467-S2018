<!doctype html>
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
                <tbody>
                  <?php
                  require_once('../config.php');
                  $query = "SELECT id, f_name, l_name, email FROM user WHERE account_type='standard'";
                  $response = mysqli_query($dbc, $query);

                  while($row = mysqli_fetch_assoc($response)){
                      echo "<tr id={$row['id']}>
                      <td> {$row['f_name']} </td>
                      <td> {$row['l_name']} </td>
                      <td> {$row['email']} </td>
                      <td>
                        <button type='button'
                              class='btn btn-secondary btn-sm active'
                              float='right'
                              data-toggle='modal'
                              data-target='#editUserModal'
                              data-id={$row['id']}
                              data-f_name={$row['f_name']}
                              data-l_name={$row['l_name']}
                              data-email={$row['email']}>
                              <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"14\" height=\"16\" viewBox=\"0 0 14 16\"><path fill-rule=\"evenodd\" d=\"M0 11.592v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3l-1.3 1.3-3-3 1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z\"/></svg>
                              Edit
                        </button>
                      </td>
                      <td>
                        <button type='button'
                              class='btn btn-danger btn-sm active'
                              float='right'
                              data-toggle='modal'
                              data-target='#deleteUserModal'
                              data-id={$row['id']}
                              data-email={$row['email']}>
                              <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"16\" viewBox=\"0 0 12 16\"><path fill-rule=\"evenodd\" d=\"M7.71 8.23l3.75 3.75-1.48 1.48-3.75-3.75-3.75 3.75L1 11.98l3.75-3.75L1 4.48 2.48 3l3.75 3.75L9.98 3l1.48 1.48-3.75 3.75z\"/></svg>
                              Delete
                        </button>
                      </td>
                      </tr>";
                    }
                    mysqli_close($dbc);
                  ?>
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
          <form>
            <div class="form-group">
              <label for="userFirstName">First name</label>
              <input  type="text"
                      class="form-control"
                      id="firstNameNew"
                      aria-describedby="firstNameHelp"
                      placeholder="Enter first name">
              <label for="userLastNameNew">Last name</label>
              <input  type="text"
                      class="form-control"
                      id="lastNameNew"
                      aria-describedby="lastNameHelp"
                      placeholder="Enter last name">
              <label for="userEmail">Email address</label>
              <input  type="email"
                      class="form-control"
                      id="userEmailNew"
                      aria-describedby="emailHelp"
                      placeholder="Enter email">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm mr-auto" data-dismiss="modal">
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
          <form>
            <div class="form-group">
              <label for="userLastName">First name</label>
              <input  type="text"
                      class="form-control"
                      id="userFirstNameToEdit"
                      aria-describedby="firstNameHelp"
                      placeholder="Enter first name">
              <label for="userLastName">Last name</label>
              <input  type="text"
                      class="form-control"
                      id="userLastNameToEdit"
                      aria-describedby="lastNameHelp"
                      placeholder="Enter last name">
              <label for="userEmail">Email address</label>
              <input  type="email"
                      class="form-control"
                      id="userEmailToEdit"
                      aria-describedby="emailHelp"
                      placeholder="Enter email">
            </div>
            <input id="userIDtoEdit" style="visibility: hidden;">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm mr-auto" data-dismiss="modal">
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
          <button type="button" class="btn btn-secondary btn-sm mr-auto" data-dismiss="modal">
            No, exit without saving changes
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="submitUserDelete">
            Yes, delete the selected account
          </button>
        </div>
      </div>
    </div>
  </div>
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
</body>
</html>
