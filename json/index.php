<?php

	include("../connect.php");

	$dept = $_GET['dept'];
    $max = $_GET['n_id'];
    $branch= $_GET['branch'];
    $class = $_GET['class'];
	//$d = $_GET['dept'];

    ///$dept = strtoupper($dept);
    
    

    $sql = "select d_id from department where d_name='$dept'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $tmp = mysqli_fetch_assoc($result);

    $d_id = $tmp['d_id'];

    $sql = "select d_id from department where d_name='$branch'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $tmp = mysqli_fetch_assoc($result);
    $b_id = $tmp['d_id'];

    $sql = "select c_id from class where c_name='$class'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $tmp = mysqli_fetch_assoc($result);
    $c_id = $tmp['c_id'];    
	
	$sql = "select n_id, name, title, uploadDate, exp,u_id  from notice a where d_id=$d_id and n_id > $max and n_id in (select n_id from n_for_c where c_id = $c_id) and n_id in (select n_id from n_for_d where d_id = $b_id) order by n_id desc";

    //echo $sql;
    
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $length = mysqli_num_rows ( $result );

    if($length > 0)
    {
        while($r = mysqli_fetch_assoc($result)) 
        {   
            $id= $r['u_id'];
            
            $sql = "select f_name,l_name from user where u_id=$id";
            $res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
            $user_details = mysqli_fetch_assoc($res);
            $user_name = $user_details['f_name'] . ' ' . $user_details['l_name'];
            $r['uploadedBy'] = $user_name;
            $rows['result'][] = $r;
        }
        echo json_encode($rows);
    }
    else
    {
        echo json_encode (json_decode ("{}"));
    }
	
?>a