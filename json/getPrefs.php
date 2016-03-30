<?php

	include("../connect.php");

	$prn = $_GET['PRN'];
    $class = $_GET['class'];
    $dept = $_GET['branch'];
    $prefs = $_GET['dprefs'];

    
    
    $dept = strtoupper($dept);
    $sql = "select d_id from department where d_name='$dept'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $dept_details = mysqli_fetch_assoc($result);

    $sql = "select u_id from student where PRN='$prn'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $user_details = mysqli_fetch_assoc($result);
    
    //u_id
    $u_id = $user_details['u_id'];
    
    //d_id
    $d_id = $dept_details['d_id'];


    $sql = "select c_id from class where c_name='$class'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $class_details = mysqli_fetch_assoc($result);

    $c_id = $class_details['c_id'];


    $sql = "update student set c_id = $c_id, d_id = $d_id where PRN = '$prn'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

    $sql = "insert into preferences (u_id, prefs) values ($u_id, '$prefs')";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    
    

?>
