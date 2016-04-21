<?php
// Start the session
session_start();
require('../db.php');

// get user information
if(isset( $_SESSION["uid"]))
{
    //$_SESSION["uid"] = ($_POST['uid']);
    $uid = $_SESSION['uid'];
    $SQL = "SELECT * FROM user WHERE uid = '$uid'";
    $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
    $rowResults = $result->fetch_array(MYSQLI_ASSOC);
    $first = $rowResults['first_name'];
    $last = $rowResults['last_name'];
}
else{
    // user must be logged in
    header("Location: ../");
}
/*
* Get all user likes from database 
* put them in likes array
* get 3 recommended artitst for each like through spotify api
*/

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
    /*
    $related_id = $results['artists'][3]['id'];
    array_push($recommended_artists, $related_id);*/
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
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    </head>
    <body>
        <!-- NAV BAR -->
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
                        <li><a href="../signout/"><span id = 'signout' class="glyphicon glyphicon-log-in"></span> Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav> <!-- NAV BAR END -->
        
        
        <!-- user side bar -->
        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-2 sidenav">
                    <h3>Users</h3>

            
                    <?php
                    /*
                    * Get users from database ot display in feed
                    */
                    
                    $SQL = "SELECT * FROM user WHERE uid != '$uid' LIMIT 10";
                    $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
                    while($rowResults = $result->fetch_array(MYSQLI_ASSOC))
                    {
                        echo" <div class='well'>";
                        echo"<p>".$rowResults['first_name']." ".$rowResults['last_name']."</p>";
                        echo"</div>";
                    }

                    ?>
                </div>
                
                <!-- recommendation feed -->
                <div class="col-sm-8 text-left"> 
                    <h1>Recommendation Feed</h1>
                    <hr>
                    <?php
                    /*
                    * For every fav create 3 divs with recommended artists
                    */
                    shuffle($recommended_artists);
                    foreach($recommended_artists as $key)
                    {
                    // api call to spotify //
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
                    $genres = $json->genres;

                    $count = 0;
                    foreach($Images[2] as $result) {
                    if($count == 1)
                    $Image = $result;
                    $count = $count + 1;
                    }
                        /* get top track for artist */
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
                        
                        
                        // check if already liked artist
                        if(in_array($key, $likes_array))
                        {
                            echo"<span class = '.like' data-id = '$key' data-name = '$Name' data-genre = '$genres[0]'><img class = 'like_icon' src = '../images/liked.png' onclick = 'like(this)'></span>";  
                        }
                        else
                        {
                            echo"<span class = '.like' data-id = '$key' data-name = '$Name'><img class = 'like_icon' src = '../images/like.png' onclick = 'like(this)'></span>";

                        }
                        echo"</p>";
            
                        echo"<iframe src='https://embed.spotify.com/?uri=$uri_track' frameborder='0' allowtransparency='true'></iframe>";
                        
                        echo"<a class = 'link' title = 'View on Spotify' href = '$uri'><img class = 's_img' src = '../images/button_s.png' alt = 'spotify'></a>";
                        
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
    
    <script type="text/javascript">
        $(document).on("click","#signout",function(event){
            event.preventDefault();
            $(".form-signup").slideUp();
            $("#login").slideUp();
            $(".form-signin").slideDown(); 
            $("#submit").show("slow");
        });
        
        function like(e)
        {
            var uid = <?php echo($uid); ?>;
            var id = $(e).data('id');
            var name = $(e).data('name');
            var genre = $(e).data('genre');
            if($(e).attr("src") == "../images/like.png")
                {
                    $(e).attr("src", "../images/liked.png");
                    $.ajax({
                        type: "POST",
                        url: '../functions/like.php',
                        data: {'uid' : uid, 'id' : id, 'name' : name, 'genre' : genre},
                        success: function(result){
                            console.log(result);
                        }
                    });   
                }
            else
                {
                    $(e).attr("src", "../images/like.png");
                    $.ajax({
                        type: "POST",
                        url: '../functions/unlike.php',
                        data: {'uid' : uid, 'id' : id},
                        success: function(result){
                            console.log(result);
                          
                        }
                    });   
                }
        }
    </script>
</html>
