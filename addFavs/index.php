<?php 
require('../db.php'); 

$email = ($_POST['email']);
$uid = 1;
$first_name = ($_POST['first_name']);
$last_name = ($_POST['last_name']);
$email = ($_POST['email']);
$password = ($_POST['password']);

$SQL = "INSERT INTO user (first_name, last_name, email, password, uid)
    VALUES ('$first_name','$last_name','$email','$password','$uid')";
$result = $server->query($SQL) or die ('Error executing: ' . $server->error);
//$rowResults = $result->fetch_array(MYSQLI_ASSOC);


$array = ['0TnOYISbd1XYRBk9myaseg'];

?>
<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="../css/addFavs.css"  media="screen,projection"/>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

        <title>Project</title>
    </head>

    <body>
        <h1><img src = '../images/logo.png'></h1>
        <!--<h1>NAME OF WEBSITE</h1>-->
        <h2>Website.com</h2>

        <div id = 'signin_box'>
            <div id = 'add_favs'>
                <h3>Add Your Favorite Artists</h3>
                <div id = 'deck'>
                    <div class = 'artist'>
                        <?php
                        foreach($array as $key)
                        {
                            $request = 'https://api.spotify.com/v1/artists/'.$key;
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $request);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $response = curl_exec($ch);
                            curl_close($ch);
                            $json = json_decode($response);
                            $Images = $json->images;
                            $Name = $json->name;
                            $id = $json->id; 
                            
                            $count = 0;
                            foreach($Images[2] as $result) {
                                if($count == 1)
                                    $Image = $result;
                                $count = $count + 1;
                            }
                            echo"<div id = 'box'>";
                            echo"<img class = 'artist_img' src ='$Image' alt = 'artist'>";
                            echo"<br/>";
                            echo($Name);
                            echo"</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
    
    <script type="text/javascript">
    </script>
</html>