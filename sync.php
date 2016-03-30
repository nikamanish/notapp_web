<?php
{   
    $prn = '';
    $key = '';
    $value = '';
    
    if(isset($_GET['prn']))
    {
        $prn = $_GET['prn'];
    }
    
    if(isset($_GET['key']))
    {
        $key = $_GET['key'];
    }
    
    if(isset($_GET['value']))
    {
        $value = $_GET['value'];
    }
    
    include("connect.php");
    
    //$stmt = mysqli_prepare($conn, "select u_id from student where PRN=?");
    
    $sql = "select u_id from student where PRN='$prn'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $user = mysqli_fetch_assoc($result);    
    $u_id = $user['u_id'];

    echo $u_id;
    
    
    if($key=='c_name')
    {
        $sql = "select c_id from class where $key='$value'";
        echo $sql."<br>";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $class = mysqli_fetch_assoc($result);  
        $c_id = $class['c_id'];
        
        $sql = "update student set c_id=$c_id where u_id=$u_id";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));                
    }
    
    elseif($key=='d_name')
    {
        $sql = "select d_id from department where $key='$value'";
        echo $sql."<br>";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $dept = mysqli_fetch_assoc($result);  
        $d_id = $dept['d_id'];
        
        $sql = "update student set d_id=$d_id where u_id=$u_id";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));                
    }
    
    elseif($key == 'prefs')
    {
        $sql = "update preferences set prefs='$value' where u_id=$u_id";
        echo $sql."<br>";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));    
    }
    
    else
    {
        $sql = "update user set $key='$value' where u_id=$u_id";
        echo $sql."<br>";
        $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));    
    }
    
}
?>