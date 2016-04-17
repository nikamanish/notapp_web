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
        
        $sql = "select D.d_name from department D inner join student S on D.d_id = S.d_id where S.u_id='$u_id'";
        $branch_res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $branch_res_arr = mysqli_fetch_assoc($branch_res);
        $branch = $branch_res_arr['d_name'];
        
        $sql = "select C.c_name from class C inner join student S on C.c_id = S.c_id where S.u_id='$u_id'";
        $class_res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $class_res_arr = mysqli_fetch_assoc($class_res);
        $class = $class_res_arr['c_name'];
        
        $branch = strtolower($branch);
        
        
        if($password == $arr['pword'])
        {
            $arr['consent'] = 1;
            $arr['dprefs'] = $prefs;
            $arr['d_name'] = $branch;
            $arr['c_name'] = $class;
            
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
