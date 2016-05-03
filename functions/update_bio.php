<?php 
require('../db.php'); 

$uid = ($_POST['uid']);
$bio = ($_POST['bio']);

$SQL = "UPDATE user_bio SET bio = '$bio' WHERE uid = '$uid'";
$result = $server->query($SQL) or die ('Error executing: ' . $server->error);

?>