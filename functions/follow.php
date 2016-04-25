<?php 
require('../db.php'); 

$uid = ($_POST['uid']);
$key = ($_POST['id']);

$SQL = "INSERT INTO user_follow (uid, follow_id)
    VALUES ('$uid','$key')";
$result = $server->query($SQL) or die ('Error executing: ' . $server->error);

?>