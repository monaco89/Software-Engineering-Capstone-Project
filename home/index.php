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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ST4U Home</title>
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
                        <li><a href="../profile/"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
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
                        <li><a href="../"><span class="glyphicon glyphicon-log-in"></span><?php echo($first." "); echo($last);?> - Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-2 sidenav">
                    <div class="well">
                        <p>Maybe put another artist here</p>
                    </div>
                    <div class="well">
                        <p>Maybe put another artist here</p>
                    </div>
                    <div class="well">
                        <p>Maybe put another artist here</p>
                    </div>
                    <div class="well">
                        <p>Maybe put another artist here</p>
                    </div>
                    <div class="well">
                        <p>Maybe put another artist here</p>
                    </div>
                </div>
                <div class="col-sm-8 text-left"> 
                    <h1>Your feed</h1>
                    <p>Scrolling feed in the middle</p>
                    <hr>
                    <h3>Recommendations</h3>
                    <p>here is this artist</p>
                    <hr>
                    <h3>Recommendations</h3>
                    <p>here is this artist</p>
                    <hr>
                    <h3>Recommendations</h3>
                    <p>here is this artist</p>
                    <hr>
                </div>

            </div>
        </div>

        <footer class="container-fluid text-center">
            <p>About us</p>
        </footer>

    </body>
</html>
