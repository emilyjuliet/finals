<?php
session_start();
require_once "class/config.php";

$email = $_SESSION['user'];

$results = $con->query( "SELECT * FROM users WHERE email = $email");
while ($row = $results->fetch_object()) {


$userName = $row->full_name;
$userEmail = $row->email;
$userRole = $row->is_admin;

}

$con->close();
