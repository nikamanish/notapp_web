<?php
 
// response json
$json = array();
 
/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($_POST["PRN"]) && isset($_POST["password"]) && isset($_POST["gcm_regid"])) {
    $prn = $_POST["PRN"];
    $password = $_POST["password"];
    $gcm_regid = $_POST["gcm_regid"]; // GCM Registration ID
    // Store user details in db
    include_once './db_functions.php';
    include_once './gcm.php';
 
    $db = new DB_Functions();
    $gcm = new GCM();
 
    $res = $db->storeUser($prn, $password, $gcm_regid);
 
    $registatoin_ids = array($gcm_regid);
    $message = array("product" => "shirt");
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;
} else {
    // user details missing
    echo "failed";
}
?>