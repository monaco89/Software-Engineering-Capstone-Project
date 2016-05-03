<?php 
session_start();
require('../db.php'); 
// get user information
if(isset( $_SESSION["uid"]))
{
    if( isset($_POST['id']) )
    {
        $uid = $_POST['id'];
    }
    else
        $uid = $_SESSION['uid'];
    
    //echo($uid);
    
    $SQL = "SELECT * FROM user WHERE uid = '$uid'";
    $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
    $rowResults = $result->fetch_array(MYSQLI_ASSOC);
    $first = $rowResults['first_name'];
    $last = $rowResults['last_name'];
    
    $SQL = "SELECT * FROM user_bio WHERE uid = '$uid'";
    $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
    $rowResults = $result->fetch_array(MYSQLI_ASSOC);
    $bio = $rowResults['bio'];

    $SQL = "SELECT * FROM likes where uid = '$uid'";
    $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
    $likes_array = array();
    
}
else{
    // user must be logged in
    header("Location: ../");
}

?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Profile</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet" />

        <link href="../css/font-awesome.css" rel="stylesheet" />

        <link rel="stylesheet" type = "text/css" href="../css/profile.css"/>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>

    </head>
    <body >
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
                        <li><a href="../home"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li class="active"><a href="../profile/"><span class="glyphicon glyphicon-user"></span><?php echo(" ".$first." ".$last);?></a></li>

                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../signout/"><span id = 'signout' class="glyphicon glyphicon-log-in"></span> Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Profile</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">

                    <div class="user-wrapper">
                        <img src="../images/profile.jpg" class="img-responsive" alt="image goes here"/> 
                        <div class="description">
                            <h4><?php echo($first." ".$last);?></h4>
                           <!-- <h5> <strong> Student </strong></h5>-->
                            <hr />
                          <!--  <a href="#" class="btn btn-danger btn-sm"> <i class="fa fa-user-plus" ></i> &nbsp;Follow Me </a> -->
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-9  user-wrapper">
                    <div class="description">
                        <?php
                         if($uid == $_SESSION['uid'])
                         {
                        ?>
                        <h3> Bio : <span id = 'edit' style = 'float:right;font-size:9pt;'>edit</span></h3>
                        <?php
                         }
                        else
                        {
                            ?>
                        <h3> Bio :</h3>
                        <?php
                        }
                        ?>
                        <hr />
                        <p id = 'bio'>
                            <?php echo($bio);?>
                        </p> 
                        <h3> Favorites: </h3>
                        <hr />                
			<?php
			
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

			 }
			
			shuffle($likes_array);
			foreach($likes_array as $key)
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

                echo"<div class = 'box'>";
                echo"<img class = 'artist_img' src ='$Image' alt = 'artist'>";
                echo"<p class = 'key' style = 'display:none;'>$key</p>";
                echo"<br/><p value = '$key' class = 'artist_title'>";
                echo($Name);
                echo"</p></div>";
            }
		    ?>	
                    </div>
                    
                    
                    <div id = 'friends'>
                        
                        <h3> Friends: </h3>
                        <hr />   
                        
                        <?php
                        $SQL = "SELECT * FROM user_follow where uid = '$uid'";
                        $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
                        while($rowResults = $result->fetch_array(MYSQLI_ASSOC))
                        {
                            $SQL2 = "SELECT * FROM user WHERE uid = '".$rowResults['follow_id']."'";
                            $result2 = $server->query($SQL2) or die ('Error executing: ' . $server->error);
                            $rowResults2 = $result2->fetch_array(MYSQLI_ASSOC);
                            $first = $rowResults2['first_name'];
                            $last = $rowResults2['last_name'];
                            $id = $rowResults2['uid'];

                            echo"<div class = 'box_user' data-id='$id' onclick = 'user_profile(this)'>";
                            echo"<form class='form-profile' id = 'form$id' role='form' action='../profile/' method='POST'>";
                            echo"<input type = 'hidden' name = 'id' value = '$id'>";
                            echo"<img class = 'artist_img' src ='../images/profile.jpg' alt = 'artist'>";
                            echo"<p class = 'key' style = 'display:none;'>$key</p>";
                            echo"<br/><p value = '$key' class = 'artist_title'>";
                            echo($first." ".$last);
                            echo"</p></form></div>"; 
                      
                        }
                        ?>
                    
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="container-fluid text-center">
            <a href="../about/" class = 'about'>About us</a>
        </footer>
    </body>
    
    <script type="text/javascript">
        $(document).on("click","#edit",function(event){
            
            if ($('#edit').text() == "done")
                {
                    var uid = <?php echo($uid); ?>;
                    var html = $('textarea').val();
                    console.log(html);
                    console.log(uid);
                    $.ajax({
                        type: "POST",
                        url: '../functions/update_bio.php',
                        data: {'uid' : uid, 'bio' : html},
                        success: function(result){
                            console.log(result);
                            $('#bio').replaceWith('<p id = "bio">'+html+'</p>').html();
                            $('#edit').text("edit");
                        }
                    }); 
                }
            else
                {
                    var html = $('#bio').html();
                    $('#bio').replaceWith('<p id = "bio"><textarea>'+html+'</textarea></p>').html();

                    $('#edit').text("done");
                }
        });
        
        function user_profile(event){
            var id = $(event).data('id');
            console.log(id);
            $('#form'+id).submit();
        };
       
    </script>

</html>
