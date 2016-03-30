<?php

	include("../connect.php");

	$prn = $_GET['PRN'];
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $dob = $_GET['dob'];
    
    //$pwd = $_GET['Password'];
	//$d = $_GET['dept'];

    ///$dept = strtoupper($dept);

    $date = explode("-",$dob);

    $dob = $date[2]."-".$date[1]."-".$date[0];

    $dob =  date('Y-m-d', strtotime($dob));
    
    echo $dob.'<br>';

    $sql = "select u_id from student where PRN='$prn'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $tmp = mysqli_fetch_assoc($result);
    
    $u_id = $tmp['u_id'];

    $sql = "update user set f_name = '$fname', l_name = '$lname', email = '$email', phone = '$phone', dob = '$dob' where u_id = $u_id";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    
    echo $result;

?>
