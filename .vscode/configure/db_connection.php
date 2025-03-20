<?php
$servername = "127.0.0.1";  // Try using the IP address instead of localhost
$username= "root";
$password="";
$dbname="tdpsphp";
$port=3307;

    $conn = new mysqli($servername,$username,$password,$dbname,$port);
    if($conn->connect_error){
        die("connection failed: " . $conn->connect_error);
    }