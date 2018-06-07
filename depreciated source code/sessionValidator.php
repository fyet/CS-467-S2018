<?php
  session_start();                 // Start a new session - http://php.net/manual/en/function.session-start.php
  // See - https://stackoverflow.com/questions/45893044/how-to-check-session-on-page-in-php
  if(!(isset($_SESSION['user']))){ // If there was a session in progress this global value would not be null. If it is null...
    $_SESSION = array();           // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead) 
    session_destroy();             // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
    header("Location: http://18.188.194.159/login.php?message=Login%20To%20Access%20Page");     // Re-direct the user to the login screen as they need to login.
  }
?>
