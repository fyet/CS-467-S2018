<?php
  session_start();     // Start a new session - http://php.net/manual/en/function.session-start.php
  $_SESSION = array(); // Set all session data to an empty array. Trick from https://www.youtube.com/watch?reload=9&v=E6ATLvTDRCs (could use http://php.net/manual/en/function.session-unset.php instead)
  session_destroy();   // Destroy the session we just started in this file - http://www.php.net/manual/en/function.session-destroy.php
  header("Location: http://18.188.194.159/award-hub/login-system/login.php?message=You%20Have%20Been%20Successfully%20Logged%20Out"); // Re-direct the user to the login screen as they need to login.
?>
