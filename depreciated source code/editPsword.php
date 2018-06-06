<?php 
    require('sessionValidator.php');
    require_once('config.php');
    require("emailHandler.php");

    // The session validator ensures the user has credentails in our system, but we also need to be sure a valid admin user can't visit the user portion of the site by going to 
    // URL directly. The code below will end the session of an admin user who tries to gain access.
    if($_SESSION['accountType'] == "admin"){
        $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
        session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
        header("Location: http://18.188.194.159/login.php?message=Admin%20Users%20May%20Not%20Access%20This%20Page");     // Re-direct the user to the login screen as they need to login.
    }

    $_SESSION['location'] = 0;
    $id = $_SESSION['user'];
    $psword = $_POST['psword'];

    $hashed_psword = password_hash($psword, PASSWORD_DEFAULT);

    $query = "UPDATE user SET psword = ? WHERE id = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'si', $hashed_psword, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    $sql = "SELECT f_name, l_name, email FROM user WHERE id =" .$id;
    $result = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
    $f_name = $row['f_name'];
    $l_name = $row['l_name'];

    $subject = "Password Change";
    $msgBody = $f_name. " " .$l_name. ",<br>
            <p>Your password has been changed.</p>
            <p>If this change was not done by you, please contact your system admin.</p>
            <p> -AwardHub Team</p>";

    emailHandler($email, $subject, $msgBody);

    header('Location: user-home.php');

?>