<!DOCTYPE html>
<html lang="en">
<head>

    <title>Add New Recipient</title>
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
  <?php require_once('config.php'); 
  session_start();?>
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
        <h3>Create New Recipient</h3>
      </div>
    </div>
  </div>

  <div class="container">
    <form action="postRecip.php" method="post">
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="f_name">Recipient's First Name:</label>
          <input class="form-control" 
          type="text" 
          id="f_name" 
          name="f_name"
          required>
        </div>
        <div class="form-group col-sm">
          <label for="l_name">Recipient's Last Name:</label>
          <input class="form-control" 
          type="text" 
          id="l_name" 
          name="l_name"
          required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="email">Recipient's Email:</label>
          <input class="form-control" 
          type="email" 
          id="email" 
          name="email" 
          value="<?php echo $_SESSION['recipE'] ?>"
          required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="branch">Select Recipient's Branch:</label>
          <?php 
          $query = "SELECT id, name FROM branch";
          $result = mysqli_query($dbc, $query);
          ?>
          <select class="form-control" id="branch" name="branch">
            <?php while($row = mysqli_fetch_assoc($result)){
              echo "<option value='" .$row['id'] ."' >" .$row['name'] ."</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group col-sm">
          <label for="manager">Select Recipient's Manager:</label>
          <?php 
          $query = "SELECT id, f_name, l_name FROM manager";
          $result = mysqli_query($dbc, $query);
          ?>
          <select class="form-control" id="manager" name="manager">
            <?php while($row = mysqli_fetch_assoc($result)){
              echo "<option value='" .$row['id'] ."' >" .$row['f_name'] ." " .$row['l_name'] ."</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="job_title">Recipient's Job Title:</label>
          <input class="form-control" 
          type="text" 
          id="job_title" 
          name="job_title"
          required>
        </div>
        <div class="form-group col=sm">
          <label for="salary">Recipient's Salary:</label>
          <input class="form-control" 
          type="number" 
          id="salary" 
          name="salary"
          required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="hire_date">Recipient's Hire Date:</label>
          <input class="form-control" 
          type="date" 
          id="hire_date" 
          name="hire_date"
          required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit Recipient</button>
    </form>
  </div>
</body>