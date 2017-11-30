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
            if(!isset($_SESSION["userSession"])){   
                header("Location: login.php");
            }
            if(isset($_SESSION["currentFriendGroup"])){
                unset($_SESSION["currentFriendGroup"]);
            }
            if(isset($_SESSION["contentIdSession"])){
                $contentId = $_SESSION["contentIdSession"];
                unset($_SESSION["contentIdSession"]);
            }
            else
                $contentId = $_POST["contentId"];
            $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
            //list all friendgroups owned that is not already shared to
            $cmd = "SELECT group_name FROM friendgroup WHERE username='$_SESSION[userSession]' AND group_name NOT IN (SELECT group_name FROM share WHERE id = '$contentId' AND username = '$_SESSION[userSession]')";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            if($result){
                echo "Share with? <br/>
                    <form action='back/addShare.php' method='POST'>";
                do{
                    echo "<input name='shareWith' type='radio' value='$result[0]' checked> $result[0] <br/>" ;
                }while($result = $statement->fetch());
                echo "
                    <input name='contentId' type='hidden' value ='$contentId'>
                    <input type='submit' value ='share'>
                    </form>
                ";
            }
            else{
               echo "You don't have any FriendGroup to share with."; 
            }            
            echo"
                <br/>
                <a href= 'content.php?contentId=$contentId'> 
                    Return to content
                </a>
            ";  
            //List all friendgroups currently shared with
            $cmd = "SELECT group_name FROM share WHERE username='$_SESSION[userSession]' AND id = '$contentId'";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            if($result){
                echo "<h3>Currently Shared With</h3>";
                do{
                    echo "<div> $result[group_name] </div>" ;
                }while($result = $statement->fetch());
            }    
            ?>
        </div>
    </body>
</html>