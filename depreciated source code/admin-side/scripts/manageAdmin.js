/********************** begin helper functions **************************/

/*Description: Sends GET request for admin table data as HTML
 *Called by: submitNewAdmin(), submitAdminEdits()
 *return value: none
 */
function loadTable(){
  $.get('components/adminTable.php', function(data){
    $('#adminTable').html(data);
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
function validateEmailField(formID, fieldID, submitBtnID, email){
  email = email || null; //optional parameter
  $(fieldID).off('input');
  $(fieldID).on('input', function(e){
    if (checkEmailFormat($(fieldID))){ //Format is valid
      //Check if email is available
      checkEmailAvailability($(fieldID).val(), fieldID, formID, submitBtnID, email);
    } else { //Format is invalid
      $(fieldID).removeClass('is-valid');
      $(fieldID).addClass('is-invalid');
      $('div.invalid-feedback-email').text('Please enter a valid email address');
      //Disable submit button
      $(submitBtnID).prop('disabled', true);
    }
  });
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
     $.get("PHP/manage-users-router.php", {email: userEmail}, function(data, success, headers){
       if (data) { //Email not available
         $(emailFieldID).removeClass('is-valid');
         $(emailFieldID).addClass('is-invalid');
         //Reset and change error message
         $('div.invalid-feedback-email').text('Account already exists with that address');
         //Disable form submit button
         $(btnID).prop('disabled', true);
       } else { //Email is valid and available
         //add is-valid class to input element
         $(emailFieldID).removeClass('is-invalid');
         $(emailFieldID).addClass('is-valid');
         //Reset and change error message
         $('div.valid-feedback').text('Good to go!');
         if (formFieldsValid(formID))
           $(btnID).prop('disabled', false);
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
      checkEmailAvailability
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


/*Description: Submits POST request to create new admin record in DB
 *Parameters: none
 *Called by:
    $('body').on('click', addAdminBtnID, submitNewAdmin)
 *Return value: none
 */
function submitNewAdmin(){
  var payload = "email=" + $("#adminEmail").val();
  //Hide modal
  $('#addAdminModal').modal('hide');
  //Submit form to be handled by PHP file
  $.ajax({
    type: "POST",
    url: "PHP/manage-admin-router.php",
    data: payload,
    cache: false,
    success: function(){
      loadTable();
      //Reset form fields
      $('#adminEmail').val('');
    }
  });
}


/*Description: Submits PUT request to edit existing admin record in DB
 *Parameters: none
 *Called by:
    $('body').on('click', editAdminBtnID, submitAdminEdits);
 *Return value: none
 */
function submitAdminEdits(){
  //Bind submit button to PUT request
  var adminID = $("#editID").val();
  var adminEmail = $("#adminEmailToEdit").val();
  var payload = JSON.stringify({id: adminID, email: adminEmail});
  //Hide modal before getting Ajax response
  $('#editAdminModal').modal('hide');
  $.ajax({
    url: 'PHP/manage-admin-router.php',
    type: 'PUT',
    data: payload,
    cache: false,
    success: function(result){
      loadTable();
    }
  });
}


/*Description: Clears all input and validity classes
 *Parameters: formID (string id of target form with '#' prepended)
 *Called by: $('#addAdminModal').on(), $('#editAdminModal').on()
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

/********************** end helper functions **************************/


//Load table initially
loadTable();

$(document).ready(function(){
  //Frequently used values
  var addAdminFormID = '#newAdminForm';
  var addAdminBtnID = '#submitNewAdmin';
  var editAdminFormID = '#editAdminForm';
  var editAdminBtnID = '#submitEdit';

  //Add event listener to add new admin button
  $('body').on('click', addAdminBtnID, submitNewAdmin);

  //Add event listener to edit admin button
  $('body').on('click', editAdminBtnID, submitAdminEdits);

  //Add event listener to opening add admin modal
  $('#addAdminModal').on('show.bs.modal', function(e){
    //Make sure form fields are clear
    clearInputValues(addAdminFormID);
    //Disable submit button
    $(addAdminBtnID).prop('disabled', true);
    //Add event listener to email field
    validateEmailField(addAdminFormID, '#adminEmail', addAdminBtnID);
  });

  //Prevent default form behavior
  $(addAdminFormID).submit(function(e){
    e.preventDefault();
  });

  //Add event listener to opening edit admin modal
  $('#editAdminModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var email = button.data('email');
    //Clean up persistent form content and attributes
    clearInputValues(editAdminFormID);
    // Update the modal's content
    $('#adminEmailToEdit').val(email);
    //Add ID in hidden form field
    var modal = $(this);
    modal.find('#editID').val(id).hide();
    modal.find('#editID').addClass('is-valid');
    //add input event listener to email field
    validateEmailField(editAdminFormID, '#adminEmailToEdit', editAdminBtnID, email);
  });

  //Prevent default form behavior
  $(editAdminFormID).submit(function(e){
    e.preventDefault();
  });

  //Add event listener to opening delete admin modal
  $('#deleteAdminModal').on('show.bs.modal', function(event) {
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
        url: 'PHP/manage-admin-router.php?id=' + id,
        type: 'DELETE',
        cache: false,
        success: function(result){
            $('#deleteAdminModal').modal('hide');
            $('#'+id).remove();
        }
      });
    });
  });
});
