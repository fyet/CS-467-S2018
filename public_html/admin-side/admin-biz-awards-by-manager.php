<?php require '../sessionValidator.php';?>

<!doctype html>
<html lang="en">
<head>
  <title>Business Insights - Manager</title>
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
            <div class="h3" id="pageTitle"><a href="admin-biz.php">Business Insights</a><strong> > </strong>Award Data by
              <div class="dropdown" style="display:inline-block;">
                <a class="btn btn-outline-dark btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Manager
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="admin-biz-awards-by-user.php">User</a>
                  <a class="dropdown-item" href="admin-biz-awards-by-recipient.php">Recipient</a>
                  <a class="dropdown-item" href="admin-biz-awards-by-branch.php">Branch</a>
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
                <!-- column chart -->
                <div class="row mt-4">
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
                    <div class="h5">Award Data by Manager</div>
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
  <?php include("components/reportControls.php"); ?>
  <!-- end report controls -->
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
      data.addColumn('number', 'Total Awards Received by Employees');
      data.addColumn('number', 'Avg. Salary of Awarded Employees');
      data.addColumn('number', 'Total Number of Awarded Employees');

      //Get data from DB
      var jsonData = $.ajax({
        url: "PHP/awardManagerData.php",
        dataType: "json",
        async: false
      }).responseText;

      //Convert JSON to array of objects
      var obj = JSON.parse(jsonData);
      var rowData = [];
      for (var i = 0; i < obj.length; i++) {
        var row =  [obj[i].fname,
                    obj[i].lname,
                    Number(obj[i].awardCount),
                    Number(obj[i].avgSalary),
                    Number(obj[i].awardedEmployeeCount)];
        rowData.push(row);
      }

      //Add all row data to table
      data.addRows(rowData);

      var table = new google.visualization.Table(document.getElementById('googleTable'));

      table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: 'true',
                        cssClassNames:{}});
    }
  </script>
  <script type="text/javascript" src="scripts/awardManagerChart.js"></script>
  <script type="text/javascript" src="scripts/managerDataToCSV.js"></script>
</body>
</html>
