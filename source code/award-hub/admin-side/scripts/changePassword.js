function changePassword(){
  //Prepare new user data for transmission
  var pw = $('#pword').val();
  var payload = JSON.stringify({psword: pw});
  //Submit form to be handled by PHP file
  $.ajax({
    type: "POST",
    url: "PHP/changePassword.php",
    data: payload,
    cache: false,
    success: function(){
      $('#passwordModal').modal('hide');
      resetForm();
    }
  });
}


function resetForm(){
  $('#pword').val(''); //Clear password field
  disableSubmitButton('#pwButton', changePassword);
  //Set all conditions as unmet
  $('.password-condition').each(function(){
    $(this).css('color', 'red');
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

$(document).ready(function(){
    $('#passwordModal').on('hide.bs.modal', function(event){
      resetForm();
    });

    //stop page from reloading
    $('#changePasswordForm').submit(function(e){
      e.preventDefault();
    });

    //Credit: http://www.plus2net.com/jquery/msg-demo/password-validation.php   
    $('#pword').keyup(function(){
        var pw = $('#pword').val();
        //Regular expressions for uppercase letter, lowcase letter, and number
        var upper_let = new RegExp('[A-Z]');
        var lower_let = new RegExp('[a-z]');
        var num_pres = new RegExp('[0-9]');

        var allConditionsMet = true; //true unless a condition fails

        //Check for uppercase letter
        if(pw.match(upper_let)){
            $('#d2').css("color", "green");
        } else {
            $('#d2').css("color", "red");
            allConditionsMet = false;
        }

        //Check for lowercase letter
        if(pw.match(lower_let)){
          $('#d3').css("color", "green");
        } else {
          $('#d3').css("color", "red");
          allConditionsMet = false;
        }

        //Check for number
        if(pw.match(num_pres)){
          $('#d4').css("color", "green");
        } else {
          $('#d4').css("color", "red");
          allConditionsMet = false;
        }

        //Check that length is greater than 7 and less than 73
        if(pw.length>7 && pw.length<73){
          $('#d5').css("color", "green");
        } else {
          $('#d5').css("color", "red");
          allConditionsMet = false;
        }

        //Check that all conditions are met before enabling submit button
        if(allConditionsMet){
          $('#d1').fadeOut();
          enableSubmitButton('#pwButton', changePassword);
        } else {
          $('#d1').show();
          $('#pwButton').prop('disabled', true);
        }
    });

    //Display instructions while conditions are unmet
    $('#pword').blur(function(){
        $('#d1').fadeOut();
    });

    //Hide
    $('#pword').focus(function(){
        $('#d1').show();
    });
});
