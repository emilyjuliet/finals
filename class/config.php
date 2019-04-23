<?php

//error reporting at level 0 is to prevent the browser from outputing such a descriptive error yenye itafanya site yako isikue secure
error_reporting(0);

$host = '127.0.0.1';
$username = 'homestead';
$password = 'secret';
$database = 'library';
$port = '3306';

$con = mysqli_connect("$host", "$username", "$password", "$database", "$port");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


?>
