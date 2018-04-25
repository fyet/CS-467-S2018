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
  <link rel="stylesheet" href="styles/custom.css">
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
        <!-- navigation cards -->
        <div class="row">
          <div class="card-deck">
            <a href="manage-users.php">
              <div class="card border-light mb-3">
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
              </div>
            </a>
            <a href="manage-admin.php">
              <div class="card border-light mb-3">
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
            </a>
            <a href="#">
              <div class="card border-light mb-3">
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
            </a>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- End sidebar and page content -->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Add custom scripts below-->
</body>
</html>