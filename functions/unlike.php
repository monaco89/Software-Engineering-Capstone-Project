<?php 
require('../db.php'); 

$uid = ($_POST['uid']);
$id = ($_POST['id']);

$SQL = "DELETE FROM likes WHERE id = '$id' AND uid = '$uid'";
$result = $seatswap->query($SQL) or die ('Error executing: ' . $seatswap->error);

?>