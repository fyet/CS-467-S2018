<!DOCTYPE html>
<html lang="en">
<head>

    <title>Search For Eployee Email</title>
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

    </style>
</head>

<body>
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
        <form action="search.php" method="post" class="form-inline justify-content-center">
            <div class="form-group" style="padding: 100px 0px">
                <input type="text" name="key" class="form-control form-control-lg" placeholder="Enter Email">
            </div>
                <button type="submit" class="btn btn-primary btn-lg">Search</button>
            </div>
        </form>
    </div>

</body>
</html>