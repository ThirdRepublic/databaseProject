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
            $error = "";
            if(isset($_SESSION["registerError"])){   
                $error = "<div class = 'error'>".$_SESSION['registerError']."</div>";
                unset($_SESSION["registerError"]);
            }
            echo "
                <form class='formreg' action='back/vertifyRegister.php' method='POST'>
                    <input name='username' placeholder='Username' type='text' /> <br/> 
                    <input name='password' type= 'password' placeholder='Password'/> <br/> 
                    <input name='FName' placeholder='First Name' type='text' /> <br/> 
                    <input name='LName' placeholder='Last Name' type='text' /> <br/> 
                    <input type='submit'>
                </form> <br/> $error
                "
            ?>
        </div>
    </body>
</html>