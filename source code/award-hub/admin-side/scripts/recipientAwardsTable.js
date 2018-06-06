function loadTable(){
  $.get('components/recipientAwardsTable.php', function(data){
    $('#recipientAwardsTable').html(data);
  });
}

$(document).ready(function(){
  loadTable(); //Load default table
});
