<?php 
    $con=mysqli_connect("localhost","rot","","honeypot");
    //check con
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_errno();        
    }
?>