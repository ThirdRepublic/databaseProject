<!DOCTYPE html>
<html>
    <head>
        <title>PriCoSha</title>
        <style>
        </style>
        <link rel = "stylesheet" href = "back/header.css">
        <?php
            session_start();
            if(!isset($_SESSION["userSession"])){   
                header("Location: login.php");
            }
            if(isset($_SESSION["currentFriendGroup"])){
                unset($_SESSION["currentFriendGroup"]);
            }
            if(isset($_SESSION["contentIdSession"])){
                unset($_SESSION["contentIdSession"]);
            }
            $error = "";
            if(isset($_SESSION["groupNameError"])){   
                $error = "<div class = 'error'>".$_SESSION['groupNameError']."</div>";
                unset($_SESSION["groupNameError"]);
            }
            $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
            $cmd = "SELECT group_name FROM friendgroup WHERE username='$_SESSION[userSession]'";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            
        ?>
    </head>
    <body>
        <?php include "back/header.php"?>
        <div id = "main">
            <?php
            if($result){
                echo "<span>$_SESSION[userSession]'s Current FriendGroups</span> <br/> <br/>";
                do{
                    echo "<a href = 'validFriendGroup.php?friendGroup=$result[0]'>$result[0]</a> <br/>" ;
                }while($result = $statement->fetch());
            }
            echo "
            <br/>
            <h3>Create new FriendGroup</h3>
            <form action='newFriendGroup.php' method='POST'>
                <input name='newGroupName' type='text' placeholder='Insert New Group Name'> <br/> 
                <input type='submit'>                
            </form> <br/> $error 
            ";
            ?>
        </div>
    </body>
</html>