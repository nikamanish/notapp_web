<?php

	include("../connect.php");

	$prn = $_GET['PRN'];
    $regId = $_GET['regId'];
    
    //$pwd = $_GET['Password'];
	//$d = $_GET['dept'];

    ///$dept = strtoupper($dept);

    echo $regId.'   '.$prn;


    $sql = "update student set gcmRegId = '$regId' where PRN = '$prn'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

?>
