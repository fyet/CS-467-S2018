<?php require '../sessionValidator.php';?>

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
        <div class="card text-center">
          <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#bi-tab-home" role="tab" data-toggle="tab">
                  Reporting Tools
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#bi-tab-diy" role="tab" data-toggle="tab">
                  Do-It-Yourself Data
                </a>
              </li>
            </ul>
          </div>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="bi-tab-home" role="tabpanel">
              <div class="card-body">
                <h5 class="card-title">Pre-baked Solutions for Your Business Needs</h5>
                <p class="card-text">
                  Want colorful, interactive charts and tables to spice up your next report? With
                  our Google Charts-powered tools, you'll be able to save your favorite graphs as
                  PNGs and export data to CSVs.
                </p>
                <p class="card-text">
                  Select from the following categories to get started on your next data adventure!
                </p>
                <div class="row">
                  <div class="col-sm mb-2">
                    <a href="admin-biz-awards-by-user.php" class="btn btn-sm btn-primary">
                      Award Data by User
                    </a>
                  </div>
                  <div class="col-sm mb-2">
                    <a href="admin-biz-awards-by-recipient.php" class="btn btn-sm btn-success">
                      Award Data by Recipient
                    </a>
                  </div>
                  <div class="col-sm mb-2">
                    <a href="admin-biz-awards-by-manager.php" class="btn btn-sm btn-danger">
                      Award Data by Manager
                    </a>
                  </div>
                  <div class="col-sm">
                    <a href="admin-biz-awards-by-branch.php" class="btn btn-sm btn-secondary">
                      Award Data by Branch
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="bi-tab-diy" role="tabpanel">
              <div class="card-body">
                <h5 class="card-title">Raw Records for Data-Miners</h5>
                <p class="card-text">
                  For those who like to work without constraints, we've put together
                  all of your organization's award data into one minimally-filtered CSV file.
                </p>
                <p class="card-text">
                  Hit the button below to download the AwardHub master table!
                </p>
                <a href="PHP/allDataToCSV.php" class="btn btn-sm btn-warning" id="csvBtn">
                  Download AwardHub Data as CSV file
                </a>
              </div>
            </div>
          </div>
        </div>
        <!-- line chart -->
        <div class="row">
          <div class="col-md-12">
            <div class="chart" id="chart1"></div>
            <div id='png'></div>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- End sidebar and page content -->
  <?php include('components/passwordModal.php'); ?>
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Google Charts library -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <!-- Add custom scripts below-->
  <script>
    $("#BIbtn").addClass("active"); //add active class to Business Insights button
  </script>
  <script type="text/javascript" src="scripts/awardsChart.js"></script>
</body>
</html>
