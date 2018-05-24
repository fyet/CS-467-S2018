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
            <div class="h3" id="pageTitle"><a href="admin-biz.php">Business Insights</a><strong> > </strong>Award Data by
              <div class="dropdown" style="display:inline-block;">
                <a class="btn btn-outline-dark btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Recipient
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="admin-biz-awards-by-user.php">User</a>
                  <a class="dropdown-item" href="#">Region</a>
                  <a class="dropdown-item" href="#">Department</a>
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
                    <div class="h5">Award Recipients</div>
                    <!--<div class="table-responsive">
                      <table class="table table-hover table-bordered table-striped table-sm">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Award Count</th>
                            <th scope="col">Hire Date</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Job Title</th>
                            <th scope="col">Manager</th>
                            <th scope="col">Branch</th>
                            <th scope="col">State</th>
                          </tr>
                        </thead>
                        <tbody id="recipientAwardsTable">
                        </tbody>
                      </table>
                    </div>-->
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
  <!-- *************************************************************************
                                Adjust filters modal
  ************************************************************************** -->
  <!-- <div  class="modal fade" id="editFiltersModal"
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
              <div class="form-group col-md-12">
                <label for="sortingCriteria">Sort by:</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">First</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01">
                    <option selected>Choose...</option>
                    <option value="1"></option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect02">Second</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect02">
                    <option selected>None</option>
                    <option value="1"></option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend" style="width:60px;">
                    <label class="input-group-text" for="inputGroupSelect03">Third</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect03">
                    <option selected>None</option>
                    <option value="1"></option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                </div>
              </div>
            </div>
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
          <button type="button" class="btn btn-danger btn-sm" id="resetFilters">
            Reset filters
          </button>
          <button type="button" class="btn btn-primary btn-sm" id="updateFilters">
            Update report filters
          </button>
        </div>
      </div>
    </div>
  </div> -->
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
      data.addColumn('number', 'Award Count');
      data.addColumn('number', 'Salary');
      data.addColumn('string', 'Hire Date');
      data.addColumn('string', 'Job Title');
      data.addColumn('string', 'Manager');
      data.addColumn('string', 'Branch');
      data.addColumn('string', 'State');

      //Get data from DB
      var jsonData = $.ajax({
        url: "awardRecipientData.php",
        dataType: "json",
        async: false
      }).responseText;

      //Convert JSON to array of objects
      var obj = JSON.parse(jsonData);
      var rowData = [];
      for (var i = 0; i < obj.length; i++) {
        var row =   [obj[i].fname,
                    obj[i].lname,
                    Number(obj[i].awardsReceived),
                    Number(obj[i].salary),
                    obj[i].hireDate,
                    obj[i].jobTitle,
                    obj[i].manager,
                    obj[i].branch,
                    obj[i].state];
        rowData.push(row);
      }

      //Add all row data to table
      data.addRows(rowData);

      var table = new google.visualization.Table(document.getElementById('googleTable'));

      table.draw(data, {showRowNumber: false, width: '100%', height: '100%', allowHtml: 'true',
                        cssClassNames:{}});
    }
  </script>
  <script type="text/javascript" src="scripts/awardRecipientLineChart.js"></script>
  <script type="text/javascript" src="scripts/recipientAwardsTable.js"></script>
  <script type="text/javascript" src="scripts/tableToCSV.js"></script>
</body>
</html>
