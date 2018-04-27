<!DOCTYPE html>
<html lang="en">
<head>
  <? php session_start(); ?>

    <title>Create Award</title>
    <!-- Meta Tags for Bootstrap -->
    <meta charset="utf-8">
    <meta name = "viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Import/Include Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <style>
        .container{
            display:flex;
            justify-content:center;
            align-items:center;
        }
    </style>
</head>

<body>

  <?php
        $my_array = array(
          1=>"Employee of The Month", 
          2=>"Employee of The Year", 
          3=>"Employee of The Week", 
          4=>"Best Dressed");
  ?>

      <nav class="navbar navbar-light bg-light">
    <!-- Menu icon -->
    <a class="navbar-brand" href="#">
      <img src="images/logo.svg" width="30" height="30" class="d-inline-block align-top" alt="">
      AwardHub User
    </a>
    <!-- Logout button -->
    <ul class="nav justify-content-end">
      <li class="nav-item">
        <a class="nav-link" href="#">logout <img src="images/Octicons/sign-out.svg" alt="logout"></a>
      </li>
    </ul>
  </nav>

  <div class="container">
    <div class="row" style="padding:50px 0px">
      <div class="col">
        <h3>Create New Award</h3>
      </div>
    </div>
  </div>

  <div class="container">
    <form action="postAward.php" method="post">
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="typeAward">Type of Award:</label>
          <select class="form-control" id="typeAward" name="typeAward">
              <?php foreach($my_array as $key => $value) { ?>
                <option value="<?php echo $key ?>"><?php echo $value ?> </option>
              <?php }?>
          </select>
        </div>
        <div class="form-group col-sm">
          <label for="dateAward">Date of Award:</label>
          <input class="form-control" type="date" id="dateAward" name="dateAward" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="recipEmail">Recipient's Email:</label>
          <input class="form-control" 
                type="text" 
                id="recipEmail" 
                name="recipEmail" 
                value="<?php echo $_SESSION['recipE']; ?>"
                readonly>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="recipFName">Recipient's First Name:</label>
          <input class="form-control" 
                type="text" 
                id="recipFName" 
                name="recipFName" 
                placeholder="Somebody" 
                readonly>
        </div>
        <div class="form-group col-sm">
          <label for="recipLName">Recipient's Last Name:</label>
          <input class="form-control"
                type="text"
                id="recipLName"
                name="recipLName"
                placeholder="Smith"
                readonly>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit Award</button>
    </form>
  </div>
</body>
