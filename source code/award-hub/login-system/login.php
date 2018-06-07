<!DOCTYPE html>
<html>
<head>

<!-- https://www.w3schools.com/tags/tag_meta.asp -->
<meta charset="utf-8">
<meta name="viewport" content="width-device-width, initial-scale=1">

<style>


input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

html, body{
	height: 100%;
	width: 100%;
	margin:0;
	background-color:#BDC3C7;
	font-family: Arial, Helvetica, sans-serif;
}

body, body{
	display:flex;
}

form {
	margin: auto;
}

button {
    background-color: #515A5A;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 75%;
}

#subButt {
	border-radius: 8px;
}

#holder{
  text-align: center;
  background-color:#BDC3C7;
  display:flex;
  justify-content:center;
  align-items:center;
}


#form_login {
	display: table-cell;
	text-align: center;
	vertical-align: middle;
}


input {
	text-align:center;
	background-color:#CACFD2;
}

button:hover {
    opacity: 0.9;
}


.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

.logo svg {
    width: 100px;
    height: 100px;
}

.container {
    padding: 16px;
    margin:auto;
    width:50%;
    background-color:#ECF0F1;

}

span.psw {
    float: middle;
    padding-top: 16px;
}


@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }

}
</style>
</head>
<body>


<div class="container" id="holder">
  <form action="./loginValidator.php" method="POST" id="form_login">
    <div class="imgcontainer">
      <div class="logo">
        <?php include("../images/logo.svg"); ?>
      </div>
    </div>
    <h2> Sign In To Award Hub </h2>
    <div class="container">
      <label for="uemail"><b>Email Address</b></label>
      <input type="text" placeholder="Enter Email Address" id="uemail" name="uemail" required>
      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" id="psw" name="psw" required>
      <button type="submit" id="subButt" name="subButt">Login</button><br>
    </div>
    <div class="container" style="color:red;font-weight:bold">
      <?php
        if(isset($_GET["message"])){
          $message = $_GET["message"];
          echo "$message";
       }
      ?>
    </div>
    <div class="container" style="background-color:#f1f1f1">
     	<span class="psw">Forgot <a href="./passwordReminder.php">password?</a></span>
   	</div>
  </form>
</div>

</body>
</html>
