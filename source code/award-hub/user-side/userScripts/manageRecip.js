function loadTable(){
    $.get('userComponents/recipTable.php', function(data){
        $('#recipTable').html(data);
    });
}


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
  email = email || null; //Make email optional
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

//Sets all form input elements as valid
function setInputsValid(formID){
  $(formID + ' :input').each(function(index){
    if ($(this).prop('required')) {
      $(this)
        .removeClass('is-invalid')
        .addClass('is-valid');
    }
  });
}


//Submits recipient edit request to server
function submitRecipientEdits(){
    var userID = $('#userIDEdit').val();
    var fname = $('#f_nameEdit').val();
    var lname = $('#l_nameEdit').val();
    var uemail = $('#emailEdit').val();
    var ubranch = $('#branchEdit').val();
    var umanager = $('#managerEdit').val();
    var jobTitle = $('#job_titleEdit').val();
    var usalary = $('#salaryEdit').val();
    var payload = JSON.stringify({id: userID,
                                f_name: fname,
                                l_name: lname,
                                email: uemail,
                                branch_id: ubranch,
                                manager_id: umanager,
                                job_title: jobTitle,
                                salary: usalary});
    $.ajax({
        url: "postRecipMod.php",
        type: 'PUT',
        data: payload,
        cache: false,
        success: function(result){
            $('#editRecipient').modal('hide');
            loadTable();
        }
    });
}


loadTable(); //Load recipient's table initially

$(document).ready(function(){
  /*Bind event listener and function just once to modal
  submit recipient edits button when page is opened*/
  $('body').on('click', '#subEdit', submitRecipientEdits);

  //Prevent default form behavior
  $('#editRecipForm').submit(function(e){
    e.preventDefault();
  });

  $('#editRecipient').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var fname = button.data('f_name');
      var lname = button.data('l_name');
      var email = button.data('email');
      var jobTitle = button.data('job_title').replace(/_/g, ' ');
      var salary = button.data('salary');

      $('#subEdit').prop('disabled', false);
      setInputsValid('#editRecipForm');

      $('#f_nameEdit').val(fname);
      $('#l_nameEdit').val(lname);
      $('#emailEdit').val(email);
      $('#job_titleEdit').val(jobTitle);
      $('#salaryEdit').val(salary);

      var modal = $(this);

      modal.find('#userIDEdit').val(id).hide();
      modal.find('#userIDEdit').addClass('is-valid');

      validateItemField('#editRecipForm', '#f_nameEdit', '#subEdit');
      validateItemField('#editRecipForm', '#l_nameEdit', '#subEdit');
      validateEmailField('#editRecipForm', '#emailEdit', '#subEdit', email);
      validateItemField('#editRecipForm', '#job_titleEdit', '#subEdit');
      validateItemField('#editRecipForm', '#salaryEdit', '#subEdit');

  });

  $('#deleteRecipModal').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget);
      var id = button.data('id');

      var modal = $(this);
      modal.find('#recipIdDelete').val(id).hide();

      $('#subDel').click(function(){
          var id = $('#recipIdDelete').val();

          $.ajax({
              url: 'postRecipMod.php?id=' + id,
              type: 'DELETE',
              cache: false,
              success: function(result){
                  $('#deleteRecipModal').modal('hide');
                  $('#' + id).remove();
              }
          });
      });
  });
});
