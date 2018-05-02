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
        <!-- column chart -->
        <div class="row" id="chart_div" style="width: 800px; height: 500px;"></div>
      </div>
    </div>
  </div> <!-- End sidebar and page content -->
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
