//Adds link to CSV download functions to report control button
$(document).ready(function(){
  $("#csvBtn").attr({
    "href": "PHP/branchDataToCSV.php"
  });
});
