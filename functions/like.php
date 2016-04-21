<?php 
require('../db.php'); 

$uid = ($_POST['uid']);
$key = ($_POST['id']);
$Name = ($_POST['name']);
$genre= ($_POST['genre']);
$seatgeek_id = 0;

$SQL = "INSERT INTO likes (uid, spotify_id, artist, seatgeek_id, genre)
    VALUES ('$uid','$key','$Name','$seatgeek_id', '$genre')";
$result = $server->query($SQL) or die ('Error executing: ' . $server->error);

?>