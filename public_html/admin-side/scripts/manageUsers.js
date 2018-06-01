/********************** begin helper functions **************************/

/*Description: Sends GET request for user table data as HTML
 *Called by: submitNewUser(), submitUserEdits()
 *return value: none
 */
function loadTable(){
  $.get('components/usersTable.php', function(data){
    $('#usersTable').html(data);
  });
}


/*Description: Checks for valid name format and sets validity classes accordingly
 *Paramters:
      formID(string id of target form with '#' prepended)
      fieldID(string id of target input element with '#' prepended)
      submitBtnID(string id of target button with '#' prepended)
 *Called by:
      $('#addUserModal').on('show.bs.modal')
      $('#editUserModal').on('show.bs.modal')
 *Return value: none
 */
function validateNameField(formID, fieldID, submitBtnID) {
  $(fieldID).off('input');
  $(fieldID).on('input', function(e){
    if (checkNameFormat($(fieldID))) {
      //Set field as valid
      $(fieldID).removeClass('is-invalid');
      $(fieldID).addClass('is-valid');
      //Check if whole form is acceptable before enabling submit
      if (formFieldsValid(formID))
        $(submitBtnID).prop('disabled', false);
    } else {
      //Set field as invalid
      $(fieldID).removeClass('is-valid');
      $(fieldID).addClass('is-invalid');
      //Disable form submit button
      $(submitBtnID).prop('disabled', true);
    }
  });
}


/*Description: Checks for valid email format and prevents duplicate account emails
 *Paramters:
      formID(string id of target form with '#' prepended)
      fieldID(string id of target input element with '#' prepended)
      submitBtnID(string id of target button with '#' prepended)
      email(Optional. Used to ignore editting target's current email in check against DB)
 *Called by:
      $('#addAdminModal').on('show.bs.modal')
 *Return value: none
 */
function validateEmailField(formID, fieldID, submitBtnID, email=null){
  $(fieldID).off('input');
  $(fieldID).on('input', function(e){
    if (checkEmailFormat($(fieldID))){ //Format is valid
      //Check if email is available
      checkEmailAvailability($(fieldID).val(), fieldID, formID, submitBtnID, email);
    } else { //Format is invalid
      $(fieldID).removeClass('is-valid');
      $(fieldID).addClass('is-invalid');
      $('div.invalid-feedback-email').text('Please enter a valid email address');
      //Disable form submit button
      $(submitBtnID).prop('disabled', true);
    }
  });
}


//Just checks that field is not empty
function checkNameFormat(inputElem){
  if (inputElem.val().length > 0)
    return true;
  return false;
}


/*Description: Checks for matching email in DB and sets validity attributes accordingly
 *Paramters:
      userEmail(string value of email input element)
      emailFieldID(string id of target email input element with '#' prepended)
      formID(string id of target form with '#' prepended)
      btnID(string id of target submit button with '#' prepended)
      startEmail(Optional. Used to ignore editting target's current email in check against DB)
 *Called by:
      validateEmailField()
 *Return value: none
 */
function checkEmailAvailability(userEmail, emailFieldID, formID, btnID, startEmail){
  if (userEmail !== startEmail) {
    $.get("PHP/manage-users-router.php", {email: userEmail}, function(data, success, headers, emailID=emailFieldID, fID=formID, bID=btnID){
      if (data) { //Email not available
        $(emailID).removeClass('is-valid');
        $(emailID).addClass('is-invalid');
        //Reset and change error message
        $('div.invalid-feedback-email').text('Account already exists with that address');
        //Disable form submit button
        $(bID).prop('disabled', true);
      } else { //Email is valid and available
        //add is-valid class to input element
        $(emailID).removeClass('is-invalid');
        $(emailID).addClass('is-valid');
        //Reset and change error message
        $('div.valid-feedback').text('Good to go!');
        if (formFieldsValid(fID))
          $(bID).prop('disabled', false);
      }
    });
  } else {
    //add is-valid class to input element
    $(emailFieldID).removeClass('is-invalid');
    $(emailFieldID).addClass('is-valid');
    //Reset and change error message
    $('div.valid-feedback').text('Good to go!');
    if (formFieldsValid(formID))
      //Enable submit button
      $(btnID).prop('disabled', false);
  }
}


/*Description: Tests email format against regular expression
 *Paramters:
      inputElem(input element object of target email field)
 *Called by:
      validateEmailField()
 *Return value: boolean (true = valid email format, false = invalid email format)
 */
function checkEmailFormat(inputElem){
  //Credit: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(inputElem.val());
}


/*Description:  Checks that all input elements in a form contain acceptable values.
                If no validity class has been assigned, field is marked invalid.
 *Paramters:
      formID(string id of target form with '#' prepended)
 *Called by:
      validateNameField()
      checkEmailAvailability()
 *Return value: boolean (true =  all fields valid, false = one or more fields invalid)
 */
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


/*Description: Clears all input and validity classes
 *Parameters: formID (string id of target form with '#' prepended)
 *Called by:
    $('#addAdminModal').on(),
    $('#editAdminModal').on()
 *Return value: none
 */
function clearInputValues(formID){
  $(formID + ' :input').each(function(index){
    $(this)
      .val('')
      .removeClass('is-valid')
      .removeClass('is-invalid');
  });
}


/*Description: Submits POST request to create new user record in DB
 *Parameters: none
 *Called by:
    $('body').on('click', addUserFormBtnID, submitNewUser)
 *Return value: none
 */
function submitNewUser(){
  //Get form field values
  var firstName = $("#firstNameNew").val();
  var lastName = $("#lastNameNew").val();
  var userEmail = $("#userEmailNew").val();
  //Prepare new user data for transmission
  var payload = JSON.stringify({f_name: firstName,
                                l_name: lastName,
                                email: userEmail});
  //Hide modal
  $('#addUserModal').modal('hide');
  //Submit form to be handled by PHP file
  $.ajax({
    type: "POST",
    url: "PHP/manage-users-router.php",
    data: payload,
    cache: false,
    success: function(){
      loadTable();
      //Reset form fields
      clearInputValues('#addUserForm');
    }
  });
}


/*Description: Submits PUT request to edit existing user record in DB
 *Parameters: none
 *Called by:
    $('body').on('click', editUserFormBtnID, submitUserEdits);
 *Return value: none
 */
function submitUserEdits(){
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
}


//Sets all form input elements as valid
function setInputsValid(formID){
  $(formID + ' :input').each(function(index){
    $(this)
      .removeClass('is-invalid')
      .addClass('is-valid');
  });
}

/********************** end helper functions **************************/


//Load table initially
loadTable();

$(document).ready(function(){
  //Frequently used values
  var addUserFormID = '#addUserForm';
  var addUserFormBtnID = '#submitNewUser';
  var editUserFormID = '#editUserForm';
  var editUserFormBtnID = '#submitEdit';

  //Add event listener to modal add user button
  $('body').on('click', addUserFormBtnID, submitNewUser);

  //Add event listener to modal edit user button
  $('body').on('click', editUserFormBtnID, submitUserEdits);

  $('#addUserModal').on('show.bs.modal', function(e){
    //Make sure form fields are clear
    clearInputValues(addUserFormID);
    //Disable form submit button
    $(addUserFormBtnID).prop('disabled', true);
    //Add input event listener to first name field
    validateNameField(addUserFormID, '#firstNameNew', addUserFormBtnID);
    //Add input event listener to last name field
    validateNameField(addUserFormID, '#lastNameNew', addUserFormBtnID);
    //add input event listener to email field
    validateEmailField(addUserFormID, '#userEmailNew', addUserFormBtnID);
  });

  //Prevent default form behavior
  $(addUserFormID).submit(function(e){
    e.preventDefault();
  });

  $('#editUserModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var firstName = button.data('f_name');
    var lastName = button.data('l_name');
    var email = button.data('email');
    //Reset validity classes on each modal opening and enable submit button
    $(editUserFormBtnID).prop('disabled', false);
    setInputsValid(editUserFormID);
    // Update the modal's content
    $('#userFirstNameToEdit').val(firstName);
    $('#userLastNameToEdit').val(lastName);
    $('#userEmailToEdit').val(email);
    //Add ID in hidden form field
    var modal = $(this);
    modal.find('#userIDtoEdit').val(id).hide();
    modal.find('#userIDtoEdit').addClass('is-valid');
    //Add input event listener to first name field
    validateNameField(editUserFormID, '#userFirstNameToEdit', editUserFormBtnID);
    //Add input event listener to last name field
    validateNameField(editUserFormID, '#userLastNameToEdit', editUserFormBtnID);
    //add input event listener to email field
    validateEmailField(editUserFormID, '#userEmailToEdit', editUserFormBtnID, email);
  });

  //Prevent default form behavior
  $(editUserFormID).submit(function(e){
    e.preventDefault();
  });

  $('#deleteUserModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var email = button.data('email');

    // Update the modal's content
    var modal = $(this);
    modal.find('.modal-body h4').text(email);
    // Add ID in hidden form field
    modal.find('#userIDtoDelete').val(id).hide();

    // Bind submit button to DELETE request
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
