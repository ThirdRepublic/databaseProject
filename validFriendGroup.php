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
                $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
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
                if(isset($_SESSION["addMemberError"])){   
                    $error = "<div class = 'error'>".$_SESSION['addMemberError']."</div>";
                    unset($_SESSION["addMemberError"]);
                }
                $friendGroup = $_GET["friendGroup"];
                //check if valid friend group since GET is used instead of POST
                $cmd = "SELECT * FROM friendgroup WHERE username='$_SESSION[userSession]' AND group_name = '$friendGroup'";
                $statement = $conn->prepare($cmd);
                $statement->execute();
                $result = $statement->fetch();
                if(!$result){
                    header("Location: friendgroup.php");
                }
                //retrives members in friend group 
                $cmd = "SELECT username, first_name, last_name FROM person WHERE username in (SELECT username FROM member WHERE username_creator='$_SESSION[userSession]' AND group_name = '$friendGroup')";
                $statement = $conn->prepare($cmd);
                $statement->execute();
                $result = $statement->fetch();
                echo "Members of <b>$friendGroup</b> FriendGroup<br/><br/>";
                do{
                echo "<div> $result[first_name] $result[last_name] (".$result['username'].") </div>";
                }while($result = $statement->fetch());
                echo "
                    <br/>
                    <div>Add user to <b>$friendGroup</b> FriendGroup</div>
                    <form action='back/registerValidMember.php' method='POST'>
                        <input name='FName' placeholder='First Name' type='text'/> 
                        <input name='LName' placeholder='Last Name' type='text'/> <br/> 
                        <input name='friendGroup' value='$friendGroup' type='hidden'/>
                        <input value = 'Add User' type='submit'>
                    </form> <br/> $error
                ";
                if(isset($_GET["FName"])&&isset($_GET["LName"])){
                    $FName = $_GET["FName"];
                    $LName = $_GET["LName"];
                    $cmd = "SELECT username,first_name,last_name FROM person WHERE first_name = '$FName' AND last_name = '$LName'";
                    $statement = $conn->prepare($cmd);
                    $statement->execute();
                    $result = $statement->fetch();
                    do{
                        echo "<a href = 'back/registerSpecficValidMember.php?username=$result[username]&FName=$FName&LName=$LName&friendGroup=$friendGroup'>(".$result[0].") $FName $LName</a> <br/>" ;
                    }while($result = $statement->fetch());
                }
            ?>
        </div>
    </body>
</html>