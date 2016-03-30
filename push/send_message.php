<?php
//if (isset($_GET["regId"]) && isset($_GET["message"])) {
    //$regId = $_GET["regId"];
    //$message = $_GET["message"];
     
    include_once './gcm.php';
     
    $gcm = new GCM();
    
    include("../connect.php");

    $sql = "select gcmRegId from student where PRN='2013BEN051'";
    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
    $tmp = mysqli_fetch_assoc($result);
    
    $regId = $tmp['gcmRegId'];
    
    echo $regId;
 
    $registation_ids = array($regId);
    
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


    $msg = array
    (
        'title' 	=> "MANISH",
        'uploadDate'=> RandomString(),
        'name'	     => RandomString(),
        'n_id'=> 4,
        'exp'	=> RandomString(),
        'dept'		=> "4",
        'link' => RandomString()
    );
    echo "<br><br><br>".json_encode($msg);
 
    $result = $gcm->send_notification($registation_ids, $msg);
 
    echo $result;
//}
?>