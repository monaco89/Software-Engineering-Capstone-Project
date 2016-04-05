<?php 
require('../db.php'); 

$uid = ($_POST['uid']);
$likes_array = ($_POST['likes_array']);

foreach($likes_array as $key)
{
    $request = 'https://api.spotify.com/v1/artists/'.$key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($response);
    //$Images = $json->images;
    $Name = $json->name;
    //$id = $json->id; 
    $seatgeek_id = 0;
    $genres = $json->genres;
    
    
    $SQL = "INSERT INTO likes (uid, spotify_id, artist, seatgeek_id, genre)
        VALUES ('$uid','$key','$Name','$seatgeek_id', '$genres[0]')";
    $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
}

?>