<?php
    $conn = mysqli_connect("10.10.13.213", "nikam", "manish") or die("<p>Could not connect to the server. Try again later</p>");
    mysqli_select_db( $conn, "moodle") or die("<p>Could not connect to the server. Try again later</p>");
?>