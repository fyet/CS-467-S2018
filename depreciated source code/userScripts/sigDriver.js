// Code from https://github.com/szimek/signature_pad/blob/master/docs/js/app.js reviewd and used as inspiration, modified for use case of this project. 

// Variable declarations
var wrapper = document.getElementById("signature-pad");
var canvas = wrapper.querySelector("canvas");
var submitBtn = document.getElementById("submitBtn");

// Create a new signature in canvas element, API details availabe at - https://github.com/szimek/signature_pad 
var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(253, 255, 183)'
});

submitBtn.addEventListener("click", function (event) {
  if (signaturePad.isEmpty()){
    document.getElementById('my_hidden').value = "empty";
    document.forms["form1"].submit();  
  }
  else{
    document.getElementById('my_hidden').value = canvas.toDataURL('image/png');
    document.forms["form1"].submit();
  }
});

