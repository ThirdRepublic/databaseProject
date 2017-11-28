<!DOCTYPE html>
<html>
    <head>
        <title>PriCoSha</title>
        <style>
        </style>
        <link rel = "stylesheet" href = "back/header.css">
    </head>
    <body>
        
        <?php include "back/header.php"?>
        <div id = "main">
            <?php
            session_start();
            if(isset($_SESSION["userSession"])){   
                echo "Hello, $_SESSION[userSession]";
            }
            else{
                header("Location: login.php");
            }
            if(isset($_SESSION["currentFriendGroup"])){
                unset($_SESSION["currentFriendGroup"]);
            }
            //test
            ?>
        </div>
    </body>
</html>