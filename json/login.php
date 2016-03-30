<?php

	include("../connect.php");

	$prn = $_GET['PRN'];
    $password = $_GET['password'];
    

    $sql = "select * from student where PRN='$prn'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $tmp = mysqli_fetch_assoc($result);
    
        
    if(count($tmp) > 1)
    {   
        $u_id = $tmp['u_id'];
        $sql = "select * from user where u_id=$u_id";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $arr = mysqli_fetch_assoc($result);
        
        $sql = "select * from preferences where u_id='$u_id'";
        $re=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $t = mysqli_fetch_assoc($re);
        $prefs = $t['prefs'];
        
        if($password == $arr['pword'])
        {
            $arr['consent'] = 1;
            $arr['dprefs'] = $prefs;
            $rows['result'][] = $arr;
            echo json_encode($rows);        
        }
        else
        {
            $a['consent'] = 0;
            $rows['result'][] = $a;
            echo json_encode($rows);                 
        }  
    }
    
    else
    {
        $a['consent'] = -1;
        $rows['result'][] = $a;
        echo json_encode($rows);        
    }
	
    //echo json_encode($consent);
?>
