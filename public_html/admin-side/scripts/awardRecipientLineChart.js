$(document).ready(function(){
  //Load package for line chart
  google.charts.load('current', {'packages':['line', 'corechart']});
  google.charts.setOnLoadCallback(drawChart1);

  function drawChart1() {
    // Create an empty data table
    var data = new google.visualization.DataTable();

    // Add column headings manually
    data.addColumn('string', 'Full Name');
    data.addColumn('number', 'Award Count');
    data.addColumn('number', 'Salary');

    var rowData = [];
    var table = document.getElementsByClassName('google-visualization-table-table')[0];
    for (var i = 1, row; row = table.rows[i]; i++) {
      var nextRow = [];
      var fullName = row.cells[0].innerHTML + ' ' + row.cells[1].innerHTML;
      var salary = (row.cells[3].innerHTML).replace(/,/g, ''); //Remove comma
      var nextRow = [fullName, Number(row.cells[2].innerHTML), Number(salary)];
      rowData.push(nextRow);
    }
    data.addRows(rowData);

    //Get width of page-content element
    var chartWidth = $('.page-content').width();
    //Get optimal height for chart ()
    //Formula: windowHeight - topMenuHeight - pageTitleHeight - tabControlsHeight - reportControlsHeight
    var chartHeight = $(window).height() - $('#topMenu').height() - $('#pageTitle').height() - $('#navTab').height() - $('#reportControls').height() - 200;

    //Set chart options
    var options = {
        title: "Number of Awards Received by Employee",
        width: chartWidth,
        height: chartHeight,
        chartArea: {
          width:chartWidth,
          left:75,
          top:50,
          bottom:50,
          right:100,
          height:chartHeight
        },
        // Gives each series an axis that matches the vAxes number below.
        series: {
          0: {targetAxisIndex: 0},
          1: {targetAxisIndex: 1}
        },
        vAxes: {
          // Adds titles to each axis.
          0: {title: 'Award Count'},
          1: {title: 'Salary ($)'}
        }
    };
    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.LineChart(document.getElementById('chart1'));

    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function() {
      var imageURI = chart.getImageURI();
      chart.innerHTML = '<img src="' + imageURI + '">';
      $("#pngBtn").attr({
        "href": imageURI,
        "data-target": "_blank"
      });
    });

    chart.draw(data, options);
  }

  //Reload chart to match changes in window dimensions
  $(window).resize(function(){
    drawChart1();
  });
  //Reload chart to match changes to table data (could be more specific)
  $("#googleTable").bind("click", function(){
    drawChart1();
  });
});
