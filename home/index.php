<?php
require('../db.php'); 

if(isset($_POST['uid']))
{
    $uid = ($_POST['uid']);
    $SQL = "SELECT * FROM user WHERE uid = '$uid'";
    $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
    $rowResults = $result->fetch_array(MYSQLI_ASSOC);
    $first = $rowResults['first_name'];
    $last = $rowResults['last_name'];
}
else
{
    $email = ($_POST['email']);
    $password = ($_POST['password']);
    $SQL = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
    $rowResults = $result->fetch_array(MYSQLI_ASSOC);
    $first = $rowResults['first_name'];  
    $last = $rowResults['last_name'];
    $uid = $rowResults['uid'];
}

$SQL = "SELECT * FROM likes WHERE uid = '$uid'";
$result = $server->query($SQL) or die ('Error executing: ' . $server->error);
//$rowResults = $result->fetch_array(MYSQLI_ASSOC);
$likes_array = array();
$recommended_artists = array();
while($rowResults = $result->fetch_array(MYSQLI_ASSOC))
{
    array_push($likes_array, $rowResults['spotify_id']);
    
    $request = 'https://api.spotify.com/v1/artists/'.$rowResults['spotify_id'].'/related-artists';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($response, true);
    
    $related_id = $results['artists'][0]['id'];
    array_push($recommended_artists, $related_id);
    $related_id = $results['artists'][1]['id'];
    array_push($recommended_artists, $related_id);
    $related_id = $results['artists'][2]['id'];
    array_push($recommended_artists, $related_id);
    $related_id = $results['artists'][3]['id'];
    array_push($recommended_artists, $related_id);
   // echo($related_id);
}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SweetTones4U</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/home.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="#">SweetTones4U</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="../home/"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="../profile/"><span class="glyphicon glyphicon-user"></span> <?php echo($first." "); echo($last);?></a></li>
                        <li><a href="../profile/#music"><span class="glyphicon glyphicon-headphones"></span> Music</a></li>
                        <li><a href="../profile/#friends"><span class="glyphicon glyphicon-globe"></span> Friends</a></li>
                        <form class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Find Artists" id = 'search_bar'>
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../"><span class="glyphicon glyphicon-log-in"></span> Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-2 sidenav">
                    <h3>Friends</h3>
                    <div class="well">
                        <p> user here</p>
                    </div>
                    <div class="well">
                        <p> user here</p>
                    </div>
                    <div class="well">
                        <p> user here</p>
                    </div>
                    <div class="well">
                        <p> user here</p>
                    </div>
                    <div class="well">
                        <p> user here</p>
                    </div>
                </div>
                <div class="col-sm-8 text-left"> 
                    <h1>Recommendation Feed</h1>
                    <hr>
                    <?php
                    foreach($recommended_artists as $key)
                    {
                    $request = 'https://api.spotify.com/v1/artists/'.$key.'';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $request);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $json = json_decode($response);
                    $Images = $json->images;
                    $Name = $json->name;
                    $id = $json->id; 
                    $uri = $json->uri;

                    $count = 0;
                    foreach($Images[2] as $result) {
                    if($count == 1)
                    $Image = $result;
                    $count = $count + 1;
                    }
                        
                        $request = 'https://api.spotify.com/v1/artists/'.$key.'/top-tracks?country=US';
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $request);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        //$json = json_decode($response);
                        $result = json_decode($response, true);
                        //$track = $json->tracks;
                        $track = $result['tracks'];
                        $uri_track = $track[0]['uri'];
                        
                    echo"<div class = 'recommendation'>";
                    echo"<img class = 'artist_img' src ='$Image' alt = 'artist'>";
                    echo"<p class = 'key' style = 'display:none;'>$key</p>";
                    echo"<p value = '$key' class = 'artist_title'>";
                    echo($Name);
                       
                    echo"</p>";
                        echo"<a title = 'View on Spotify' href = '$uri'><img class = 's_img' src = '../images/spotify.png' alt = 'spotify'></a>";
                    echo"<p class = 'link'>View Artist <br/>on Spotify </p>";
                        echo"<iframe src='https://embed.spotify.com/?uri=$uri_track' frameborder='0' allowtransparency='true'></iframe>";
                        echo"</div>";
                    }
                    
                    ?>
                    
                    <hr>
                </div>

            </div>
        </div>

        <footer class="container-fluid text-center">
            <p>About us</p>
        </footer>

    </body>
</html>
