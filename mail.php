<?php
    $to      = 'nikamanish007@gmail.com';
    $subject = 'php mail';
    $message = 'hello';
    $headers = 'From: admin@notapp.com' . "\r\n" .
   'Reply-To: admin@notapp.com' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();

    if(mail($to, $subject, $message, $headers))
    {
        echo 'mail sent';
    }
    else
    {
        echo 'mail not sent';
    }
?>
