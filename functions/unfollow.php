<?php 
require('../db.php'); 

$uid = ($_POST['uid']);
$id = ($_POST['id']);

$SQL = "DELETE FROM user_follow WHERE follow_id = '$id' AND uid = '$uid'";
$result = $server->query($SQL) or die ('Error executing: ' . $seatswap->error);

?>