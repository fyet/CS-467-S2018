function loadTable(){
  $.get('components/usersTable.php', function(data){
    $('#usersTable').html(data);
  });
}

//Load table initially
loadTable();

$(document).ready(function(){
  $("#submitNewUser").click(function(){
    var firstName = $("#firstNameNew").val();
    var lastName = $("#lastNameNew").val();
    var userEmail = $("#userEmailNew").val();
    var payload = JSON.stringify({f_name: firstName,
                                  l_name: lastName,
                                  email: userEmail});
    //Add validation here later
    //Submit form to be handle by PHP file
    $.ajax({
      type: "POST",
      url: "PHP/manage-users-router.php",
      data: payload,
      cache: false,
      success: function(){
        $('#addUserModal').modal('hide');
        //Reset form fields
        $('#firstNameNew').val('');
        $('#lastNameNew').val('');
        $('#userEmailNew').val('');
        loadTable();
      }
    });
  });

  $('#editUserModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var firstName = button.data('f_name');
    var lastName = button.data('l_name');
    var email = button.data('email');
    // Update the modal's content
    var modal = $(this);
    $('#userFirstNameToEdit').val(firstName);
    $('#userLastNameToEdit').val(lastName);
    $('#userEmailToEdit').val(email);
    //Add ID in hidden form field
    modal.find('#userIDtoEdit').val(id).hide();

    //Bind submit button to PUT request
    $("#submitEdit").click(function(){
      var userID = $("#userIDtoEdit").val();
      var firstName = $("#userFirstNameToEdit").val();
      var lastName = $("#userLastNameToEdit").val();
      var userEmail = $("#userEmailToEdit").val();
      var payload = JSON.stringify({id: userID,
                                    f_name: firstName,
                                    l_name: lastName,
                                    email: userEmail});
      $.ajax({
        url: 'PHP/manage-users-router.php',
        type: 'PUT',
        data: payload,
        cache: false,
        success: function(result){
          $('#editUserModal').modal('hide');
          loadTable();
        }
      });
    });
  });

  $('#deleteUserModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var email = button.data('email');

    // Update the modal's content
    var modal = $(this);
    modal.find('.modal-body h4').text(email);
    //Add ID in hidden form field
    modal.find('#userIDtoDelete').val(id).hide();

    //Bind submit button to DELETE request
    $("#submitUserDelete").click(function(){
      var id = $("#userIDtoDelete").val();

      $.ajax({
        url: 'PHP/manage-users-router.php?id=' + id,
        type: 'DELETE',
        cache: false,
        success: function(result){
            $('#deleteUserModal').modal('hide');
            $('#'+id).remove();
        }
      });
    });
  });
});
