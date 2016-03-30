<?php
 
class DB_Functions {
 
    private $db;
    private $conn;
 
    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->conn = $this->db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($prn, $password, $gcm_regid) {
        // insert user into database
        $sql = "INSERT INTO user (f_name, l_name, email, phone, avatar, dob, pword, type) VALUES('$prn', NULL, NULL, NULL, NULL, NULL, NULL, 2)";
        $result = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
        $id = mysqli_insert_id($this->conn) or die(mysqli_error($this->conn));
        
        $sql = "INSERT INTO student (PRN, password, u_id, c_id, d_id, gcm_regid) VALUES('$prn', '$password', $id ,1,1, '$gcm_regid')";
        $result = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
        // check for successful store
        if ($result) {
            // get user details
             // last inserted id
             $id = mysqli_insert_id($this->conn) or die(mysqli_error($this->conn));
            $result = mysqli_query($this->conn, "SELECT * FROM student WHERE id = $id") or die(mysqli_error($this->conn));
            // return user details
            if (mysqli_num_rows($result) > 0) {
                return mysqli_fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
 
    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM user");
        return $result;
    }
 
}
 
?>