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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SweetTones4U</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/about.css" rel="stylesheet">
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
                <div class="colla
                            pse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="../home/"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="../profile/"><span class="glyphicon glyphicon-user"></span> <?php echo($first." "); echo($last);?></a></li>
                        <!-- <li><a href="../profile/#music"><span class="glyphicon glyphicon-headphones"></span> Music</a></li>
<li><a href="../profile/#friends"><span class="glyphicon glyphicon-globe"></span> Friends</a></li>-->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../signout/"><span id = 'signout' class="glyphicon glyphicon-log-in"></span> Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav> <!-- NAV BAR END -->
        
        <div class="container">
            <p>SweetTone4U is a music recommendation site that finds the best fit music for you. It uses state of the art technology to find the best possible recommendation based on the artists, albums, and song you have liked. With this application you can easily share, like, and listen to all your colleagues music as well as your own. </p>
        </div>
        
    </body>
</html>

