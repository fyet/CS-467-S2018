<!DOCTYPE html>
<?php
  require '../login-system/sessionValidator.php';

  // The session validator ensures the user has credentails in our system, but we also need to be sure a valid standard user can't visit the admin portion of the site by going to
  // URL directly. The code below will end the session of a standard user who tries to gain access.
  if($_SESSION['accountType'] == "standard"){
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead)
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=Standard%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
  }

?>
<html lang="en">
<head>
  <title>Business Insights - Users</title>
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
  <?php require_once "components/navbar.php"; ?>
  <!-- Sidebar and page content wrappers -->
  <div class="container-fluid">
    <div class="row">
      <!-- *********************************************************************
                                  responsive sidebar
      ********************************************************************** -->
      <?php require_once "components/sidebar.php"; ?>
      <!-- *********************************************************************
                                    page content
      ********************************************************************** -->
      <div class="col-sm-12 page-content">
        <div class="row">
          <div class="col-xl">
            <div class="h3" id="pageTitle"><a href="admin-biz.php">Business Insights</a><strong> > </strong>Award Data by
              <div class="dropdown" style="display:inline-block;">
                <a class="btn btn-outline-dark btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  User
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="admin-biz-awards-by-branch.php">Branch</a>
                  <a class="dropdown-item" href="admin-biz-awards-by-recipient.php">Recipient</a>
                  <a class="dropdown-item" href="admin-biz-awards-by-manager.php">Manager</a>
                </div>
              </div>
            </div>
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Chart view</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Data view</a>
              </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <!-- chart -->
                <div class="row mt-2">
                  <div class="col-xl">
                    <p style="font-size:0.75rem;">
                      Chart tips: Hover over the graph below to interact with the data
                      and gain more insights. If you want to see the data it's based on
                      or change how it's sorted, check out the 'Data View' tab.
                      Want the chart to be smaller, wider, or flatter before exporting it
                      as an image? Simply adjust the chart dimensions by resizing your
                      browser window.
                    </p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl">
                    <div class="chart" id="chart1"></div>
                    <div id='png'></div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <!-- database-generated users table -->
                <div class="row mt-4">
                  <div class="col-xl">
                    <div class="h5">Awards Totals by AwardHub User</div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl">
                    <p style="font-size:0.75rem;">
                      Click on the column headings in the table below to sort
                      the data in ascending or descending order by that field.
                      Any changes in the ordering of data in this table will be
                      reflected in the corresponding graph within the 'Chart
                      View' tab.
                    </p>
                  </div>
                </div>
                <!-- end users table -->
                <div id="googleTable"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- End sidebar and page content -->
  <!-- start report controls -->
  <?php require_once "components/reportControls.php"; ?>
  <!-- end report controls -->
  <?php include('components/passwordModal.php'); ?>
  <!-- Optional JavaScript -->
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

  <script type="text/javascript">
    google.charts.load('current', {'packages':['table']});
    google.charts.setOnLoadCallback(drawTable);

    function drawTable() {
      //Add column headings manually
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'First Name');
      data.addColumn('string', 'Last Name');
      data.addColumn('number', 'Awards Given');
      data.addColumn('number', 'Years with Award Privileges');

      //Get data from DB
      var jsonData = $.ajax({
        url: "PHP/awardGranterData.php",
        dataType: "json",
        async: false
      }).responseText;

      //Convert JSON to array of objects
      var obj = JSON.parse(jsonData);
      var rowData = [];
      for (var i = 0; i < obj.length; i++) {
        var row =  [obj[i].fname,
                    obj[i].lname,
                    Number(obj[i].awardsGiven),
                    Number(obj[i].yearsWithAwardPrivileges)];
        rowData.push(row);
      }

      //Add all row data to table
      data.addRows(rowData);

      var table = new google.visualization.Table(document.getElementById('googleTable'));

      table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: 'true',
                        cssClassNames:{}});
    }
  </script>
  <script type="text/javascript" src="./scripts/userDataToCSV.js"></script>
  <script type="text/javascript" src="./scripts/awardGranterChart.js"></script>
  <script type="text/javascript" src="./scripts/changePassword.js"></script>
</body>
</html>
