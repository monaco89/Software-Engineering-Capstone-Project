<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="css/signin.css"  media="screen,projection"/>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        
        <title>Project</title>
    </head>
    
    <body>
        <h1><img src = 'images/logo.png'></h1>
        <!--<h1>NAME OF WEBSITE</h1>-->
        <h2>Shit Music Recommendations</h2>
        
        <div id = 'signin_box'>
            <form class="form-signup" role="form" action="addFavs/addFavs.php" method="POST">
            <input type="text" class="form-control" name="first_name" value="" placeholder="First Name" autofocus><br>
            <input type="text" class="form-control" name="last_name" value=""  placeholder="Last Name"><br>
            <input type="email" class="form-control" name="email" value=""  placeholder="Email Address"><br/>
            <input type="password" class="form-control" name="password" value=""  placeholder="Password"><br>
                <button id = 'register' type = 'submit'>Register</button>
            </form>
            <a id = 'login' href ="">Sign in</a>
            
            <form class="form-signin" name = 'Form' role="form" action="home/index.php" method="post">
                <input id = 'login_email' type="email" class="form-control" name="email" value=""  placeholder="Email Address"><br/>
                <input id = 'login_password' type="password" class="form-control" name="password" value=""  placeholder="Password">
                <input id = 'uid' type="hidden" class="form-control" name="password" value=""><br>
                <button id = 'submit' type = 'submit'>Sign in</button>
            </form>
        </div>
    </body>
    
    <script type="text/javascript">
        $(document).on("click","#login",function(event){
            event.preventDefault();
            $(".form-signup").slideUp();
            $("#login").slideUp();
            $(".form-signin").slideDown();  
        });
        
        $('form-signin').submit(function(){
            var email = $("#login_email").val();
            var password = $("#login_password").val();

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
    </script>
</html>