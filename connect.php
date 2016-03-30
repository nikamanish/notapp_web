<?php
  $conn = mysqli_connect("localhost", "root", "") or die("<p>Could not connect to the server. Try again later</p>");
    mysqli_select_db( $conn, "notapp") or die("<p>Could not connect to the server. Try again later</p>");
?>