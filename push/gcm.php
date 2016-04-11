<?php
 
class GCM {
 
    //put your code here
    // constructor
    function __construct() {
         
    }
 
    /**
     * Sending Push Notification
     */
    public function send_notification($registration_ids, $message) {
        
        // API access key from Google API's Console
        define( 'API_ACCESS_KEY', 'AIzaSyBBKn1H2Du4kC4n_P1_2LDggHm6EJgYm8M' );
        //$registrationIds = array( $_GET['id'] );
        
        // prep the bundle
        
        $fields = array
        (
            'registration_ids' 	=> $registration_ids,
            'data'			=> $message
        );

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields) );
        $result = curl_exec($ch);
        
        //echo "<br><br><br>".json_encode( $fields)."<br>";
        
        curl_close( $ch );
        //echo "<br><br><br>".$result;
    }
 
}
 
?>