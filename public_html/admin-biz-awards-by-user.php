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
        <div class="row">
          <div class="col-xl">
            <p class="h3"><a href="admin-biz.php">Business Insights</a><strong> > </strong>Award Data by User</p>
          </div>
        </div>
        <!-- column chart -->
        <div class="row" id="chart_div" style="width: 800px; height: 500px;"></div>
        <!-- database-generated users table -->
        <div class="row">
          <div class="col-xl">
            <p class="h3">Users</p>
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email address</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  require_once('config.php');
                  $query = "SELECT id, f_name, l_name, email FROM user WHERE account_type='standard'";
                  $response = mysqli_query($dbc, $query);

                  while($row = mysqli_fetch_assoc($response)){
                      echo "<tr>
                      <td> {$row['f_name']} </td>
                      <td> {$row['l_name']} </td>
                      <td> {$row['email']} </td>
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
  <!-- start report controls -->
  <nav class="navbar fixed-bottom navbar-light bg-dark" id="reportControls">
        <button type="button"
                class="btn btn-danger btn-sm"
                float="right"
                data-toggle="modal"
                data-target="#editFiltersModal">
          Adjust Report Filters
        </button>
        <div class="float-right">
          <button type="button"
                  class="btn btn-success btn-sm"
                  float="right"
                  data-toggle="modal"
                  data-target="#">
            Download Report as .CSV File
          </button>
          <button type="button"
                  class="btn btn-success btn-sm"
                  float="right"
                  data-toggle="modal"
                  data-target="#">
            Download Graph as .PNG File
          </button>
        </div>
    <!-- end report controls -->
  </nav>
  <!-- *************************************************************************
                                Adjust filters modal
  ************************************************************************** -->
  <div  class="modal fade" id="editFiltersModal"
        tabindex="-1" role="dialog"
        aria-labelledby="editFiltersModal"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editFiltersModalTitle">Adjust Report Filters</h5>
          <button type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="form-group col-md-6">
                <label for="userList">Award Granters</label>
                <select class="custom-select" multiple size="5">
                  <option selected>All</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
                <small class="form-text text-muted">
                  (hold down the CTRL key to select multiple values)
                </small>
              </div>
              <div class="form-group col-md-6" style="padding-left: 30px;">
                <div class="row">
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label for="dateRange">Date range</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <input type="date" name="startDate" class="form-control" min="1900-01-02">
                      <small class="form-text text-muted">
                        start date
                      </small>
                    </div>
                    <div class="form-group col-md-6">
                      <input type="date" name="endDate" class="form-control" min="2000-01-02">
                      <small class="form-text text-muted">
                        end date
                      </small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm mr-auto" data-dismiss="modal">
            Exit without saving changes
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="updateFilters">
            Update report filters
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
  <!-- Google Charts library -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      // Create an empty data table
      var data = new google.visualization.DataTable();

      // Add column headings manually
      data.addColumn('string', 'Last Name');
      data.addColumn('number', 'Salary');


      //Get data from BLS(TEST)
      /*var blsData = $.ajax({
        url: "BLSdata.php",
        dataType: "json",
        async: false
      }).responseText;
      console.log(blsData);*/

      // Get row data from AwardHub DB
      var jsonData = $.ajax({
        url: "recipientData.php",
        dataType: "json",
        async: false
      }).responseText;
      //console.log(jsonData);
      //Convert json string to array of objects
      var obj = JSON.parse(jsonData);
      var rowData = [];
      for (var i = 0; i < obj.length; i++) {
        var nextRow = [obj[i].l_name, Number(obj[i].salary)];
        rowData.push(nextRow);
      }
      //Add db data to DataTable
      data.addRows(rowData);
      //Set chart options
      var options = {
              title: "Salaries of Award Recipients",
              width: 800,
              height: 500,
              bar: {groupWidth: "95%"},
              legend: { position: "none" },
      };
      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
      }

  </script>
  <!-- Add custom scripts below-->
</body>
</html>
