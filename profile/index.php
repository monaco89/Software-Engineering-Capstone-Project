<?php 
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
    
    $SQL = "SELECT * FROM user_bio WHERE uid = '$uid'";
    $result = $server->query($SQL) or die ('Error executing: ' . $server->error);
    $rowResults = $result->fetch_array(MYSQLI_ASSOC);
    $bio = $rowResults['bio'];
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
                        <li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo(" ".$first." ".$last);?></a></li>
                       <!-- <li><a href="#"><span class="glyphicon glyphicon-headphones"></span> Music</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-globe"></span> Friends</a></li>-->
                        <form class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Find Artists">
                            </div>
                            <button type="submit" class="btn btn-default">Search</button>
                        </form>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
                            <h5> <strong> Student </strong></h5>
                            <hr />
                          <!--  <a href="#" class="btn btn-danger btn-sm"> <i class="fa fa-user-plus" ></i> &nbsp;Follow Me </a> -->
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-9  user-wrapper">
                    <div class="description">
                        <h3> User's Biography : </h3>
                        <hr />
                        <p>
                            <?php echo($bio);?>
                        </p>  
                        <h3> Friends and Favorites: </h3>
                        <hr />                

                    </div>

                </div>
            </div>
        </div>

    </body>

</html>
