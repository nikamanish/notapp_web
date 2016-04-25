<?php
    
    if(isset($_GET['password']))
    {
        $current = $_GET['password'];

        include("../connect.php");
        $cookie_name = "notapp_username";
        $username = $_COOKIE[$cookie_name];

        $sql = "select pword from user where email='$username'";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

        $user_details = mysqli_fetch_assoc($result);
        $password = $user_details['pword'];

        if($password == $current)
        {
            echo "true";
        }
        else
        {
            echo "false";
        }

        
    }
?>