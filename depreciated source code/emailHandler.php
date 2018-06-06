<?php
// Import necessary PHPmailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//subject, body, and certification path are optional arguments
function emailHandler($recipientEmail,$subject="",$body="",$certPath=""){

      // The code structure below is from phpmailer's manual: https://github.com/PHPMailer/PHPMailer
      require 'vendor/autoload.php'; // the autoload file

      $mail = new PHPMailer(true);
      try {
          //Server settings
          $mail->SMTPDebug = 0;   // Set this to '2' for logging/debugging details to be printed to browser
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'camelopardalis.awardhub@gmail.com';
          $mail->Password = 'cs467group!@#$';
          $mail->SMTPSecure = 'tls';
          $mail->Port = 587;

          //Recipients
          $mail->setFrom('camelopardalis.awardhub@gmail.com', 'Award Hub');
          $mail->addAddress($recipientEmail);

          //Attachments
          if (strcmp($certPath, "") != 0) {
            $mail->addAttachment($certPath);
          }
          //Content
          $mail->isHTML(true);
          $mail->Subject = $subject;
          $mail->Body    = $body;
          $mail->AltBody = $body;

          $mail->send();
          echo 'Message has been sent';
      } catch (Exception $e) {
          echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
      }
}
