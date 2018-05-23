$(document).ready(function(){
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart1);

  function drawChart1() {
    // Create an empty data table
    var data = new google.visualization.DataTable();

    // Add column headings manually
    data.addColumn('string', 'Date');
    data.addColumn('number', 'Award Count');

    // Get row data from AwardHub DB
    var jsonData = $.ajax({
      url: "awardsData.php",
      dataType: "json",
      async: false
    }).responseText;
    //Convert json string to array of objects
    var obj = JSON.parse(jsonData);
    var rowData = [];
    for (var i = 0; i < obj.length; i++) {
      var nextRow = [obj[i].accolade_date, Number(obj[i].awardsGiven)];
      rowData.push(nextRow);
    }
    //Add db data to DataTable
    data.addRows(rowData);

    //Get width of page-content element
    var chartWidth = $('.page-content').width();
    //Set chart options
    var options = {
            title: "Total awards given over time",
            width: chartWidth,
            legend: { position: "none" },
            chartArea: {width:chartWidth,left:50,top:50,bottom:50,height:450}
    };
    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.LineChart(document.getElementById('chart1'));

    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
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
});
