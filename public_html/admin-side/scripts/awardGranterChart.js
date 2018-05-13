$(document).ready(function(){
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart1);

  function drawChart1() {
    // Create an empty data table
    var data = new google.visualization.DataTable();

    // Add column headings manually
    data.addColumn('string', 'Full Name');
    data.addColumn('number', 'Awards Givens');

    // Get row data from AwardHub DB
    var jsonData = $.ajax({
      url: "awardGranterData.php",
      dataType: "json",
      async: false
    }).responseText;
    //console.log(jsonData);
    //Convert json string to array of objects
    var obj = JSON.parse(jsonData);
    var rowData = [];
    for (var i = 0; i < obj.length; i++) {
      var fullName = obj[i].fname + ' ' + obj[i].lname;
      var nextRow = [fullName, Number(obj[i].awardsGiven)];
      rowData.push(nextRow);
    }
    //Add db data to DataTable
    data.addRows(rowData);
    //Set chart options
    var options = {
            title: "Number of Awards Given by User",
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
    };
    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.ColumnChart(document.getElementById('chart1'));

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
