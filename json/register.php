<?php

	include("../connect.php");

	$prn = $_GET['PRN'];
    $password = $_GET['password'];
    //$pwd = $_GET['Password'];
	//$d = $_GET['dept'];
    $ctr=0;
    ///$dept = strtoupper($dept);

    $sql = "select * from student where PRN='$prn'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    
    while($tmp = mysqli_fetch_assoc($result))
    {
        
        $ctr++;
        //echo  "<br>"."  ".$tmp['u_id']."<br>";
    }


    //echo $ctr."<br>".mysqli_num_rows($result);

    if($ctr > 0)
    {   
       $consent['result'][]['consent'] = 0;
    }
    
    else
    {
         
        $rand = RandomString();
        $sql = "insert into user(f_name, l_name, email, phone, dob, pword, type) values('$rand', '$rand', '$rand', '$rand', '$rand', '$password', 2)" ;
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        
        $id = mysqli_insert_id($conn);
        
        $sql = "insert into student(PRN, u_id, c_id, d_id) values('$prn', $id, 1, 1)" ;
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        
        $sql = "insert into preferences (u_id, prefs) values ($id, '')";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        
        $consent['result'][]['consent'] = 1; 
    }

    function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) 
        {
            $randstring .= $characters[rand(0, strlen($characters)-1)];
        }
        return $randstring;
    }
	
    echo json_encode($consent);
?>
