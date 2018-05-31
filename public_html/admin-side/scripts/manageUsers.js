function loadTable(){
  $.get('components/usersTable.php', function(data){
    $('#usersTable').html(data);
  });
}


//Clears all input and dynamically assigned classes
function clearInputValues(formID){
  $(formID + ' :input').each(function(index){
    $(this)
      .val('')
      .removeClass('is-valid')
      .removeClass('is-invalid');
  });
}


//Just checks that field is not empty
function checkNameFormat(inputElem){
  if (inputElem.val().length > 0)
    return true;
  return false;
}


function checkEmailFormat(inputElem){
  //Credit: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(inputElem.val());
}


function checkEmailAvailability(userEmail, emailFieldID, formID, btnID, submitFunction, startEmail){
  if (userEmail !== startEmail) {
    $.get("PHP/manage-users-router.php", {email: userEmail}, function(data, success, headers, emailID=emailFieldID, fID=formID, bID=btnID, funct=submitFunction){
      if (data) { //Email not available
        $(emailID).removeClass('is-valid');
        $(emailID).addClass('is-invalid');
        //Reset and change error message
        $('div.invalid-feedback-email').text('Account already exists with that address');
        disableSubmitButton(bID);
      } else { //Email is valid and available
        //add is-valid class to input element
        $(emailID).removeClass('is-invalid');
        $(emailID).addClass('is-valid');
        //Reset and change error message
        $('div.valid-feedback').text('Good to go!');
        if (formFieldsValid(fID))
          enableSubmitButton(bID, funct);
      }
    });
  } else {
    //add is-valid class to input element
    $(emailFieldID).removeClass('is-invalid');
    $(emailFieldID).addClass('is-valid');
    //Reset and change error message
    $('div.valid-feedback').text('Good to go!');
    if (formFieldsValid(formID))
      enableSubmitButton(btnID, submitFunction);
  }
}


function formFieldsValid(formID) {
  //Iterate over inputs to check for is-valid class
  var valid = true;
  $(formID + ' :input').each(function(index){
    if (!$(this).hasClass('is-valid')) {
      $(this).addClass('is-invalid');
      valid = false;
    }
  });
  return valid;
}


function submitNewUser(){
  //Get form field values
  var firstName = $("#firstNameNew").val();
  var lastName = $("#lastNameNew").val();
  var userEmail = $("#userEmailNew").val();
  //Prepare new user data for transmission
  var payload = JSON.stringify({f_name: firstName,
                                l_name: lastName,
                                email: userEmail});
  //Submit form to be handled by PHP file
  $.ajax({
    type: "POST",
    url: "PHP/manage-users-router.php",
    data: payload,
    cache: false,
    success: function(){
      $('#addUserModal').modal('hide');
      //Reset form fields
      clearInputValues('#addUserForm');
      loadTable();
    }
  });
}


function enableSubmitButton(btnID, btnFunction){
  //Remove disabled property from button
  $(btnID).prop('disabled', false);
  //Bind form submission function to click event
  $('body')
    .off('click', btnID, btnFunction) //Prevents same event listener from being bound multiple times
    .on('click', btnID, btnFunction);
}


//Note: buttonID must have a '#' prepended
function disableSubmitButton(buttonID, btnFunction) {
  //Add disabled property to button element
  $(buttonID).prop('disabled', true);
  //Remove any event listener added with '.on()'
  $('body').off('click', buttonID, btnFunction);
}


function validateNameField(formID, fieldID, submitBtnID, submitFunction) {
  $(fieldID).on('input', function(e){
    if (checkNameFormat($(fieldID))) {
      //Set field as valid
      $(fieldID).removeClass('is-invalid');
      $(fieldID).addClass('is-valid');
      //Check if whole form is acceptable before enabling submit
      if (formFieldsValid(formID))
        enableSubmitButton(submitBtnID, submitFunction);
    } else {
      //Set field as invalid
      $(fieldID).removeClass('is-valid');
      $(fieldID).addClass('is-invalid');
      disableSubmitButton(submitBtnID);
    }
  });
}

function validateEmailField(formID, fieldID, submitBtnID, submitFunction, email=null){
  $(fieldID).on('input', function(e){
    if (checkEmailFormat($(fieldID))){ //Format is valid
      //Check if email is available
      checkEmailAvailability($(fieldID).val(), fieldID, formID, submitBtnID, submitFunction, email);
    } else { //Format is invalid
      $(fieldID).removeClass('is-valid');
      $(fieldID).addClass('is-invalid');
      $('div.invalid-feedback-email').text('Please enter a valid email address');
      disableSubmitButton(submitBtnID);
    }
    if (formFieldsValid(formID)) {
      enableSubmitButton(submitBtnID, submitFunction);
    }
  });
}

function submitUserEdits(){
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
}

$(document).ready(function(){
  //Frequently used values
  var addUserFormID = '#addUserForm';
  var addUserFormBtnID = '#submitNewUser';
  var editUserFormID = '#editUserForm';
  var editUserFormBtnID = '#submitEdit';
  //Load table initially
  loadTable();

  $('#addUserModal').on('show.bs.modal', function(e){
    //Make sure form fields are clear
    clearInputValues(addUserFormID);
    //Disable submit button initially
    disableSubmitButton('#submitNewUser');
    //Add input event listener to first name field
    validateNameField(addUserFormID, '#firstNameNew', addUserFormBtnID, submitNewUser);
    //Add input event listener to last name field
    validateNameField(addUserFormID, '#lastNameNew', addUserFormBtnID, submitNewUser);
    //add input event listener to email field
    validateEmailField(addUserFormID, '#userEmailNew', addUserFormBtnID, submitNewUser);
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
    modal.find('#userIDtoEdit').addClass('is-valid');
    //Add input event listener to first name field
    validateNameField(editUserFormID, '#userFirstNameToEdit', editUserFormBtnID, submitUserEdits);
    //Add input event listener to last name field
    validateNameField(editUserFormID, '#userLastNameToEdit', editUserFormBtnID, submitUserEdits);
    //add input event listener to email field
    validateEmailField(editUserFormID, '#userEmailToEdit', editUserFormBtnID, submitUserEdits, email);


    //Bind submit button to PUT request
  /*  $("#submitEdit").click(function(){
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
    });*/
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
