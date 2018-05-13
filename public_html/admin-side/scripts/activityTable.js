$(document).ready(function(){
  //Set default date range
  var start = '1900-01-01';
  var today = currentDate();
  //Assign default dates to range filter fields
  $('#startDate').val(start);
  $('#endDate').val(today);
  loadTable(start, today); //Load default table

  $('#updateActivityTable').click(function(){
    //Get values from input form
    var newStart = $('#startDate').val();
    var newEnd = $('#endDate').val();
    //Send request to reload table
    loadTable(newStart, newEnd);
  });
});

function loadTable(startDate, endDate){
  $.get('components/activityTable.php', {start:startDate, end:endDate}, function(data){
    $('#activityTable').html(data);
  });
}

function currentDate(){
  var d = new Date();
  //Get current day of the month and pad with 0 as necessary
  var day = d.getDate().toString();
  if (day < 10)
    day = '0' + day.toString();
  //Get current month and pad with 0 as necessary
  var month = d.getMonth() + 1;
  if (month < 10)
    month = '0' + month.toString();
  //Return date in format 'yyyy/mm/dd'
  return d.getFullYear().toString() + '-' + month + '-' + day;
}
