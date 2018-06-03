<!DOCTYPE html>
<?php require '../sessionValidator.php';?>
<html lang="en">
<head>
  <title>Manage Admin</title>
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
        <!-- add new administrator button -->
        <div class="row">
          <div class="col-xl">
            <div class="float-right">
              <button type="button"
                      class="btn btn-primary btn-md active"
                      float="right"
                      data-toggle="modal"
                      data-target="#addAdminModal">
                + Add New Administrator
              </button>
            </div>
          </div>
        </div>
        <!-- database-generated admin table -->
        <div class="row">
          <div class="col-xl">
            <p class="h3">AwardHub Administrators</p>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Email address</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody id="adminTable">
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- end admin table -->
      </div>
    </div>
  </div> <!-- End sidebar and page content -->
  <!-- *************************************************************************
                                Add new admin modal
  ************************************************************************** -->
  <!-- Add new admin modal -->
  <div  class="modal fade" id="addAdminModal"
        tabindex="-1" role="dialog"
        aria-labelledby="addAdminModal"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addAdminModalTitle">Add New Administrator</h5>
          <button type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Data is sent to current page -->
          <form method="post" id="newAdminForm" novalidate>
            <div class="form-group">
              <label for="adminEmail">Email address</label>
              <input  type="email"
                      class="form-control"
                      id="adminEmail"
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
          </form>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
              Exit without saving changes
            </button>
            <button id="submitNewAdmin" type="button" class="btn btn-primary btn-sm">
              Submit new administrator
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- *************************************************************************
                                Edit admin modal
  ************************************************************************** -->
  <div  class="modal fade" id="editAdminModal"
        tabindex="-1" role="dialog"
        aria-labelledby="editAdminModal"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editAdminModalTitle">Edit Existing Administrator</h5>
          <button type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editAdminForm" novalidate>
            <div class="form-group">
              <label for="adminEmail">Email address</label>
              <input  type="email"
                      class="form-control is-valid"
                      id="adminEmailToEdit"
                      aria-describedby="emailHelp">
              <div class="valid-feedback">
                Good to go!
              </div>
              <div class="invalid-feedback invalid-feedback-email">
                Please provide a valid email address
              </div>
            </div>
            <input id="editID" style="visibility: hidden;">
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
                                Delete admin modal
  ************************************************************************** -->
  <div  class="modal fade" id="deleteAdminModal"
        tabindex="-1" role="dialog"
        aria-labelledby="deleteAdminModal"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteAdminModalTitle">Delete Existing Administrator</h5>
          <!-- top-right-corner X -->
          <button type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <p>You have selected to permanently delete the AwardHub administrative account of:</p>
          <h4></h4>
          <p>Are you sure you want to delete this account?</p>
          <input id="deleteID" style="visibility: hidden;"> <!-- Holds admin id -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
            No, exit without saving changes
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="submitDelete">
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
  <!-- Add custom scripts below -->
  <script>
    $("#manageAdminBtn").addClass("active"); //add active class to manage admin button
  </script>
  <script type="text/javascript" src="scripts/manageAdmin.js"></script>
  <script type="text/javascript" src="scripts/changePassword.js"></script>
</body>
</html>
