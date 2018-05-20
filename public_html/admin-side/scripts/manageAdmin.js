function loadTable(){
  $.get('components/adminTable.php', function(data){
    $('#adminTable').html(data);
  });
}

//Load table initially
loadTable();

$(document).ready(function(){
  $("#submitNewAdmin").click(function(){
    var email = $("#adminEmail").val();
    var payload = "email=" + email;
    //Add validation here later
    //Submit form to be handle by PHP file
    $.ajax({
      type: "POST",
      url: "manage-admin-router.php",
      data: payload,
      cache: false,
      success: function(){
        $('#addAdminModal').modal('hide');
        //Reset form fields
        $('#adminEmail').val('');
        loadTable();
      }
    });
  });

  $('#editAdminModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var email = button.data('email');
    // Update the modal's content
    var modal = $(this);
    $('#adminEmailToEdit').val(email);
    //Add ID in hidden form field
    modal.find('#editID').val(id).hide();

    //Bind submit button to PUT request
    $("#submitEdit").click(function(){
      var adminID = $("#editID").val();
      var adminEmail = $("#adminEmailToEdit").val();
      var payload = JSON.stringify({id: id, email: adminEmail});

      $.ajax({
        url: 'manage-admin-router.php',
        type: 'PUT',
        data: payload,
        cache: false,
        success: function(result){
            $('#editAdminModal').modal('hide');
            loadTable();
        }
      });
    });
  });

  $('#deleteAdminModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var email = button.data('email');

    // Update the modal's content
    var modal = $(this);
    modal.find('.modal-body h4').text(email);
    //Add ID in hidden form field
    modal.find('.modal-body input').val(id).hide();

    //Bind submit button to DELETE request
    $("#submitDelete").click(function(){
      var id = $("#deleteID").val();

      $.ajax({
        url: 'manage-admin-router.php?id=' + id,
        type: 'DELETE',
        cache: false,
        success: function(result){
            //window.location.reload(true);
            $('#deleteAdminModal').modal('hide');
            $('#'+id).remove();
        }
      });
    });
  });
});
