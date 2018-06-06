<?php
    require_once('config.php');
    require("emailHandler.php");

    $email = $_POST['email'];

    $sql = "SELECT id, f_name, l_name FROM user WHERE  email LIKE '" . $email . "'";
    $result = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($result);
    if(isset($row['id'])){
        $pwd = str_shuffle(bin2hex(openssl_random_pseudo_bytes(4)));

        $hashed_psword = password_hash($pwd, PASSWORD_DEFAULT);

        $query = "UPDATE user SET psword = ? WHERE id = ?";
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, 'si', $hashed_psword, $row['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $subject = "Awardhub Password Reset";
        $msgBody = $row['f_name']. " " .$row['l_name']. ",<br>
                    <p>You have requested a password reset.</p>
                    <p>Here is your temporary password:</p>
                    <p><strong>" .$pwd. "</strong></p>
                    <p>If you did not request this, please contact your system admin.</p>
                    <p> -Awardhub Team</p>";

        emailHandler($email, $subject, $msgBody);
    }
    mysqli_close($dbc);

    header("Location: login.php");

?>