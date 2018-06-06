<!DOCTYPE html>
<html lang="en">
<head>

    <title>Password Reset</title>
    <!-- Required meta tags for Bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles/custom.css">

    <style>
        .container{
            display:flex;
            justify-content:center;
            align-items:center;
        }

        html, body{
          height: 100%;
          width: 100%;
          margin:0;
          background-color:#BDC3C7;
          font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
  <!-- Start brand/logo element -->
  <a class="navbar-brand" href="login.php">
    <img src="images/logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    <!-- Start responsive heading -->
    <div class="d-sm-none d-inline">
      User <!-- Appears small screens -->
    </div>
    <div class="d-none d-sm-inline">
      AwardHub Password Reset <!-- Displayed on larger screens -->
    </div>
    <!-- End responsive heading -->
  </a>
  <!-- End brand/logo element -->
</nav>

<div class="container">
  <div class="jumbotron">
    <h3 class="display-4">Password Reset</h3>
    <p class="lead">Enter your email and click submit to have a temporary password sent to you.</p>
    <hr class="my-4">
    <form action="./createTempPass.php" method="post">
      <div class="form-row">
        <label for="email">Email:</label>
        <input class="form-control" 
              type="email" 
              id="email" 
              name="email" 
              required>
      </div>
      <br>
      <button type="submit" id="subButt" class="btn btn-primary">Get Password</button>
    </form>
  </div>
</div>

</body>