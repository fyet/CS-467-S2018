//Takes two string dates ('YYYY-MM-DD') and return a list of dates in the range (non-inclusive)
//Credit: https://stackoverflow.com/questions/4413590/javascript-get-array-of-dates-between-2-dates
Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

function getDatesBetween(startDate, stopDate) {
    var dateArray = new Array();
    var currentDate = startDate.addDays(1);
    while (currentDate < stopDate) {
        dateArray.push(new Date (currentDate));
        currentDate = currentDate.addDays(1);
    }
    return dateArray;
}

$(document).ready(function(){
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart1);

  function drawChart1() {
    // Create an empty data table
    var data = new google.visualization.DataTable();

    // Add column headings manually
    data.addColumn('date', 'Date');
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
      //Add in-between dates to data table
      if (i > 0) {
        var betweenDates = getDatesBetween(new Date(obj[i-1].accolade_date), new Date(obj[i].accolade_date));
        betweenDates.forEach(function(d){
          rowData.push([d, 0]);
        });
      }
      //Add current date to data table
      var nextRow = [new Date(obj[i].accolade_date), Number(obj[i].awardsGiven)];
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
