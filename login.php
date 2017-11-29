<!DOCTYPE html>
<html>
    <head>
        <title>PriCoSha</title>
        <style>
        </style>
        <link rel = "stylesheet" href = "back/login.css">
    </head>
    <body>
        <?php include "back/loginHeader.php"?>
        <div id = "main">
            <?php
            session_start();
            if(isset($_SESSION["userSession"])){   
                header("Location: index.php"); 
            }
            if(isset($_SESSION["currentFriendGroup"])){
                    unset($_SESSION["currentFriendGroup"]);
            }
            if(isset($_SESSION["contentIdSession"])){
                unset($_SESSION["contentIdSession"]);
            }
            $error = "";
            if(isset($_SESSION["loginError"])){   
                $error = "<div class = 'error'>".$_SESSION['loginError']."</div>";
                unset($_SESSION["loginError"]);
            }
            echo "<span>Log in</span>
                <form action='back/vertifyLogin.php' method='POST'>
                    <input name='username' type='text' placeholder='Username'> <br/> 
                    <input name='password' type='password' placeholder='Password'> <br/> <br/> 
                    <input type='submit'>
                </form> <br/> $error 
                <a href='register.php'>Register</a>
                "
                ?>
        </div>
    </body>
</html>