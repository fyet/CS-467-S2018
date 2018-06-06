function validateItemField(formID, fieldID, submitBtnID) {
  $(fieldID).off('input');
  $(fieldID).on('input', function(e){
    if (checkFormat($(fieldID))) {
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


function checkFormat(inputElem){
  if (inputElem.val())
    return true;
  return false;
}

function validateEmailField(formID, fieldID, submitBtnID, email){
  email = email || null;
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

function checkEmailAvailability(userEmail, emailFieldID, formID, btnID, startEmail){
  if (userEmail !== startEmail) {
    $.get("checkRecipEmail.php", {email: userEmail}, function(data, success, headers){
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
    $('div.valid-feedback').text('Looks Good!');
    if (formFieldsValid(formID))
      //Enable submit button
      $(btnID).prop('disabled', false);
  }
}

function checkEmailFormat(inputElem){
  //Credit: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(inputElem.val());
}

//updated to only check fields with 'required' property
function formFieldsValid(formID) {
  //Iterate over inputs to check for is-valid class
  var valid = true;
  $(formID + ' :input').each(function(index){
    if (!$(this).hasClass('is-valid') && $(this).prop('required')) {
      $(this).addClass('is-invalid');
      valid = false;
    }
  });
  return valid;
}

$(document).ready(function(){
  $('#subButt').prop('disabled', true);

  validateItemField('#addRecip', '#f_name', '#subButt');
  validateItemField('#addRecip', '#l_name', '#subButt');
  validateEmailField('#addRecip', '#email', '#subButt');
  validateItemField('#addRecip', '#job_title', '#subButt');
  validateItemField('#addRecip', '#salary', '#subButt');
  validateItemField('#addRecip', '#hire_date', '#subButt');
});
