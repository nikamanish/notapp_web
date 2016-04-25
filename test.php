<?php
    $msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);

    // send email
    if(mail("nikamanish007@gmail.com","My subject",$msg))
    {
        echo "mail sent";
    }
    else
    {
        echo "not sent";
    }
?>