<?php require('db.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="css/signin.css"  media="screen,projection"/>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    </head>
    
    <body>
        <h1><img src = 'images/logo.png'></h1>
        <!--<h1>NAME OF WEBSITE</h1>-->
        <h2>Website.com</h2>
        
        <div id = 'signin_box'>
            <form class="form-signup" role="form" action="" method="post">
            <input type="text" class="form-control" name="first_name" value="" placeholder="First Name" autofocus><br>
            <input type="text" class="form-control" name="last_name" value=""  placeholder="Last Name"><br>
            <input type="email" class="form-control" name="email" value=""  placeholder="Email Address"><br/>
            <input type="password" class="form-control" name="password" value=""  placeholder="Password"><br>
                <button id = 'submit' type = 'submit'>Register</button>
            </form>
            <a id = 'login' href ="">Sign in</a>
            
            <form class="form-signin" role="form" action="" method="post">
                <input type="email" class="form-control" name="email" value=""  placeholder="Email Address"><br/>
                <input type="password" class="form-control" name="password" value=""  placeholder="Password"><br>
                <button id = 'submit' type = 'submit'>Sign in</button>
            </form>
            
            <div id = 'add_favs'>
                <h3>Add Your Favorite Artists</h3>
                <div id = 'deck'>
                    <div class = 'artist'>
                        <img class = 'artist_img' src ='' alt = 'artist'>
                    </div>
                </div>
            </div>
        </div>
    </body>
    
    <script type="text/javascript">
        $(document).on("click","#login",function(event){
            event.preventDefault();
            $(".form-signup").slideUp();
            $("#login").slideUp();
            $(".form-signin").slideDown();  
        });
        
        $(document).on("click","#submit",function(event){
            event.preventDefault();
            $(".form-signup").slideUp();
            $("#login").slideUp();
            $('#signin_box').css('width','800px');
            $('#signin_box').css('height','400px');
            $("#add_favs").slideDown(); 
        });
    </script>
</html>