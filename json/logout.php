<?php

	include("../connect.php");

	$prn = $_GET['PRN'];

    $sql = "update student set gcmRegId='' where PRN='$prn'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    //echo json_encode($consent);
?>