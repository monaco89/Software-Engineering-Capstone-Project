<?php 
require('../db.php'); 

$email = ($_POST['email']);
$password = ($_POST['password']);

$SQL = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
$result = $server->query($SQL) or die ('Error executing: ' . $server->error);

if($result == "")
    echo("failed");
else
{
    $rowResults = $result->fetch_array(MYSQLI_ASSOC);
    $uid = $rowResults['uid'];
    echo($uid);
}
?>