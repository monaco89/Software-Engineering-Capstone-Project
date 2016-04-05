<?php 
require('../db.php'); 
/*
$email = ($_POST['email']);
//$uid = 1;
$first_name = ($_POST['first_name']);
$last_name = ($_POST['last_name']);
$email = ($_POST['email']);
$password = ($_POST['password']);


$SQL = "INSERT INTO user (first_name, last_name, email, password)
    VALUES ('$first_name','$last_name','$email','$password')";
$result = $server->query($SQL) or die ('Error executing: ' . $server->error);
//$rowResults = $result->fetch_array(MYSQLI_ASSOC);
*/

$array = ['3TVXtAsR1Inumwj472S9r4','60d24wfXkVzDSfLS6hyCjZ', '6PXS4YHDkKvl1wkIl4V8DL', '6FBDaR13swtiWwGhX1WQsP', '2YZyLoL8N0Wb9xBt1NhZWg', '6l3HvQ5sa6mXTsMTB19rO5', '0BvkDsjIUla7X0k6CSWh1I', '69GGBxA162lTqCwzJG5jLp', '1uNFoZAHBGtllmzznpCI3s', '3gd8FJtBJtkRxdfbTu19U2', '02kJSzxNuaWGqwubyUba0Z', '5K4W6rqBFWDnAN6FQUkS6x', '20sxb77xiYeusSH8cVdatc', '6BrvowZBreEkXzJQMpL174', '6yJCxee7QumYr820xdIsjo', '7CajNmpbOovFoOoasH2HaY', '5pKCCKE2ajJHZ9KAiaK11H', '7iZtZyCzp3LItcw1wtPI3D', '1RyvyyTE3xzB2ZywiAwp0i', '5IcR3N7QB1j6KBL8eImZ8m', '0c173mlxpT3dSFRgMO8XPh', '0hCNtLu0JehylgoiP8L4Gh', '55Aa2cqylxrFIXC767Z865', '2IvkS5MXK0vPGnwyJsrEyV', '3b8QkneNDz4JHKKKlLgYZg', '53XhwfbYqKCa1cC15pYq2q', '3GBPw9NK25X1Wt2OUvOwY3', '16oZKvXb6WkQlVAjwo2Wbg', '4D75GcNG95ebPtNvoNVXhz', '1vCWHaC5f2uS3yhpwWbIA6', '1Cs0zKBU1kc0i8ypK3B9ai', '2o5jDhtHVPhrJdv3cEQ99Z'];

?>
<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="../css/addFavs.css"  media="screen,projection"/>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="../css/animate.css" />
        <script src="../js/jquery.viewportchecker.js"></script>

        <title>SweetTones4U</title>
    </head>

    <body>
        <div id = 'title_box'>
        <h1><img src = '../images/logo.png'></h1>
        <!--<h1>NAME OF WEBSITE</h1>-->
            <h2>Add Your Favorite Artists</h2>
        </div>
        
        <div id = 'signin_box'>
            <form class="form-addFavs" role="form" action="../home/" method="POST">
            <div id = 'add_favs'>
                <div id = 'deck'>
                  
                        <?php
                        shuffle($array);
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
                            echo"<div class = 'box'>";
                            echo"<img class = 'artist_img' src ='$Image' alt = 'artist'>";
                            echo"<p class = 'key' style = 'display:none;'>$key</p>";
                            echo"<br/><p value = '$key' class = 'artist_title'>";
                            echo($Name);
                            echo"</p></div>";
                        }
                        ?>
                    
                </div>
            </div>
        </div>
        <input type="hidden" id = 'uid' value = '<?php echo($uid);?>'>
        <button type = 'submit' id = 'continue'>Continue</button>
        </form>
    </body>
    
    <script type="text/javascript">
        var like_array = [];
        $(document).on("click",".box",function(event){
            event.preventDefault();
            var randomColor = Math.floor(Math.random()*16777215).toString(16);
            $(this).css('box-shadow',' 0px 0px 22px 10px #'+randomColor); 
            var id = $(this).find(".key").text();
            console.log(id);
            like_array.push(id);
            console.log(like_array);
        });
        
        $('form-addFavs').submit(function(){
            $.ajax({
                type: "POST",
                url: 'functions/login.php',
                data: {'email' : email, 'password' : password},
                success: function(result){
                    console.log(result);
                    if(result == 'success')
                    {
                        $("#uid").val() = 1;
                        return true;
                    }
                    else
                        alert('wrong email or password');
                }
            });  
        });
        
        jQuery(document).ready(function() {
            jQuery('.box').addClass("hidden").viewportChecker({
                classToAdd: 'visible animated flipInX',
                offset: 100
            });
        });
    </script>
</html>