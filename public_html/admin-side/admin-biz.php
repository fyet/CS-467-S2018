<!doctype html>
<html lang="en">
<head>
  <title>Business Insights</title>
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
            <p class="h3">Business Insights</p>
          </div>
        </div>
        <div class="card-deck">
          <a href="admin-biz-awards-by-user.php">
            <div class="card border-light text-white bg-success mb-3">
              <div class="card-wrapper">
                <div class="card-header text-center">View Awards Given by User</div>
                <div class="card-body">
                </div>
              </div> <!-- end card wrapper -->
            </div>
          </a>
          <a href="admin-biz-awards-by-recipient.php">
            <div class="card border-light text-white bg-success mb-3">
              <div class="card-wrapper">
                <div class="card-header text-center">View Awards Recieved By Individuals</div>
                <div class="card-body">
                </div>
              </div> <!-- end card wrapper -->
            </div>
          </a>
          <a href="admin-biz-awards-by-department.php">
            <div class="card border-light text-white bg-success mb-3">
              <div class="card-wrapper">
                <div class="card-header text-center">View Awards Received by Departments</div>
                <div class="card-body">
                </div>
              </div> <!-- end card wrapper -->
            </div>
          </a>
          <a href="#">
            <div class="card border-light text-white bg-success mb-3">
              <div class="card-wrapper">
                <div class="card-header text-center">View Awards Received by Managers' Employees</div>
                <div class="card-body">
                </div>
              </div> <!-- end card wrapper -->
            </div>
          </a>
          <a href="admin-biz-awards-by-region.php">
            <div class="card border-light text-white bg-success mb-3">
              <div class="card-wrapper">
                <div class="card-header text-center">View Awards Received by Region</div>
                <div class="card-body">
                </div>
              </div> <!-- end card wrapper -->
            </div>
          </a>
          <a href="#">
            <div class="card border-light text-white bg-success mb-3">
              <div class="card-wrapper">
                <div class="card-header text-center">View Awards Recieved by Branch Location</div>
                <div class="card-body">
                </div>
              </div> <!-- end card wrapper -->
            </div>
          </a>
        </div>
        <!-- column chart -->
        <div class="row">
          <div class="col-md-12">
            <div class="chart" id="chart1"></div>
            <div id='png'></div>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- End sidebar and page content -->

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Google Charts library -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- Add custom scripts below-->
  <script type="text/javascript" src="scripts/awardsChart.js"></script>
</body>
</html>
