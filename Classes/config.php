<?php
//error reporting at level 0 is to prevent the browser from outputing such a descriptive error yenye itafanya site yako isikue secure
error_reporting(1);
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'library';

//using mysqli drive
$db = new mysqli($host, $username, $password, $database);

var_dump($db);

//var_dump($db->connect(localhost, precise64, root, library ));
var_dump($db->connect($host, $username, $password, $database));

//would have given the parameter as the name of the database if only I'd created it
if($db->connect(localhost, root, root, library )) {
    echo "success";

} else {

    die("Wrong Credentials");

}

?>