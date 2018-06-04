$(document).ready(function(){
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart1);

  function drawChart1() {
    // Create an empty data table
    var data = new google.visualization.DataTable();

    // Add column headings manually
    data.addColumn('string', 'Full Name');
    data.addColumn('number', 'Total Awards Received by Employees');
    data.addColumn('number', 'Total Awarded Employees');

    var rowData = [];
    var table = document.getElementsByClassName('google-visualization-table-table')[0];
    for (var i = 1, row; row = table.rows[i]; i++) {
      var nextRow = [];
      var fullName = row.cells[0].innerHTML + ' ' + row.cells[1].innerHTML;
      var nextRow = [fullName,
                    Number(row.cells[2].innerHTML),
                    Number(row.cells[4].innerHTML)];
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
        title: "Award Data by Manager",
        width: chartWidth,
        height: chartHeight,
        bar: {groupWidth: "95%"},
        chartArea: {
          width:chartWidth,
          left:125,
          top:50,
          bottom:50,
          right:150,
          height:chartHeight
        }
    };
    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.BarChart(document.getElementById('chart1'));

    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function() {
      var imageURI = chart.getImageURI();
      //Open chart image in new tab when PNG button is clicked
      $('#pngBtn').off(); //reset
      $('#pngBtn').on('click', function(){
        //Credit: https://stackoverflow.com/questions/46666559/base64-image-open-in-new-tab-window-is-not-allowed-to-navigate-top-frame-naviga
        var imageTab = window.open();
        imageTab.document.body.innerHTML = '<img src="' + imageURI + '">';
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
