<?php

$localList = array(
'127.0.0.1',
'::1'
);

$onServer = (!in_array($_SERVER['REMOTE_ADDR'], $localList));

if($onServer){
//server varialbes - use if running on server, don't if running locally
$host = '';
$user = "";
$pwd = "";
$dbname = "";


}
else{
//local variables - use if running locally, don't if running on server
$host = "127.0.0.1";
$user = "root";
$pwd = "root";
$dbname = "se_project";


}

//this variable is your connection (handle) to the database
$server = new mysqli( $host,$user,$pwd,$dbname);

if(mysqli_connect_error())
die('Connection error' . mysqli_connect_errno() . ':' . mysqli_connect_error());

//next two lines not ness


?>