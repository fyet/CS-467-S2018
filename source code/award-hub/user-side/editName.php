<?php
    require('../login-system/sessionValidator.php');
    require_once('../database-resources/config.php');
    $_SESSION['location'] = 0;

    // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
    // URL directly. The code below will end the session of an admin user who tries to gain access.
    if($_SESSION['accountType'] == "admin"){
      $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
      session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
      header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
    }


    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $id = $_SESSION['user'];

    $query = "UPDATE user SET f_name = ?, l_name = ? WHERE id = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'ssi', $f_name, $l_name, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($dbc);

    header('Location: http://18.188.194.159/award-hub/user-side/user-home.php');

?>