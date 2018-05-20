<!doctype html>
<html lang="en">
<head>
  <title>Admin Home</title>
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
        <div class="row">
          <div class="col-xl">
            <p class="h3">AwardHub Admin Home</p>
          </div>
        </div>
        <!-- navigation cards -->
        <div class="row">
          <div class="col-xl">
            <div class="card-deck">
              <a href="manage-users.php">
                <div class="card border-light text-white bg-primary mb-3">
                  <div class="card-wrapper">
                    <div class="card-header">Manage Users</div>
                    <div class="card-body">
                      <p class="card-text">
                        <ul>
                          <li>add new user</li>
                          <li>edit existing users</li>
                          <li>delete existing users</li>
                        </ul>
                      </p>
                    </div>
                  </div> <!-- end card wrapper -->
                </div>
              </a>
              <a href="manage-admin.php">
                <div class="card border-light text-white bg-primary mb-3">
                  <div class="card-wrapper">
                    <div class="card-header">Manage Administrators</div>
                    <div class="card-body">
                      <p class="card-text">
                        <ul>
                          <li>add new administrator</li>
                          <li>edit existing administrators</li>
                          <li>delete existing administrators</li>
                        </ul>
                      </p>
                    </div>
                  </div>
                </div>
              </a>
              <a href="admin-biz.php">
                <div class="card border-light text-white bg-primary mb-3">
                  <div class="card-wrapper">
                    <div class="card-header">Business Insights</div>
                    <div class="card-body">
                      <p class="card-text">
                        <ul>
                          <li>run database queries</li>
                          <li>export data to CSV file</li>
                          <li>generate graphs</li>
                        </ul>
                      </p>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <!-- database-generated activity log -->
        <div class="row align-items-center" style="margin-top:40px;">
          <div class="col-md-4">
            <p class="h3 text-success">Activity Log</p>
          </div>
          <div class="form-group col-md-auto">

            <div class="row">
              <div class="col-md-auto">
                <p class="h4 text-success"><br>Date Range</p>
              </div>
              <div class="form-group col-md-auto">
                <small class="form-text text-muted">
                  start date
                </small>
                <input  id="startDate"
                        type="date"
                        name="startDate"
                        class="form-control bg-success text-white"
                        min="1900-01-01">
              </div>
              <div class="form-group col-md-auto">
                <small class="form-text text-muted">
                  end date
                </small>
                <input  id="endDate"
                        type="date"
                        name="endDate"
                        class="form-control bg-success text-white"
                        min="1900-01-02">
              </div>
              <div class="form-group col-md-auto">
                <br>
                <button id="updateActivityTable" type="button" class="btn btn-outline-success btn-md">
                  Update
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl">
            <div class="table-responsive">
              <table class="table table-hover table-sm">
                <tbody id="activityTable">
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- end activity log -->
      </div>
    </div>
  </div> <!-- End sidebar and page content -->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Add custom scripts below-->
  <script>
    $("#homeBtn").addClass("active"); //add active class to home button
  </script>
  <script type="text/javascript" src="scripts/activityTable.js"></script>
</body>
</html>
