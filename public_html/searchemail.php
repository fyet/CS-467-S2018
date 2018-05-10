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
    <link rel="stylesheet" href="styles/custom.css">
</head>

<body>
    <?php include("userComponents/navbar.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php include("userComponents/sidebar.php"); ?>

            <div class="container">
                <form action="search.php" method="post" class="form-inline justify-content-center">
                    <div class="form-group" style="padding: 100px 0px">
                        <input type="text" name="key" class="form-control form-control-lg" placeholder="Enter Email">
                    </div>
                        <button type="submit" class="btn btn-primary btn-lg">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>