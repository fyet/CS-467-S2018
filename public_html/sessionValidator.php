<?php
  /* Citations
     1. https://stackoverflow.com/questions/19690834/session-variables-not-carrying-over-to-other-pages
     2. https://stackoverflow.com/questions/45893044/how-to-check-session-on-page-in-php
     3. http://php.net/manual/en/function.session-start.php
     4. http://php.net/manual/en/function.session-unset.php
  */
  session_start();                 // Start a new session
  if(!(isset($_SESSION['user']))){ // Check to see if there is no session active
    //unset($_SESSION['user']);      // Unset variable that might now have value after calling session start & using in this function - http://php.net/manual/en/function.unset.php
    session_destroy();             // Destroy the session we just started - http://www.php.net/manual/en/function.session-destroy.php
    // Re-direct the user to the login screen as they need to login.
    header("Location: http://18.188.194.159/login.php?error=Login%20To%20Access%20Page");
  }

?>
