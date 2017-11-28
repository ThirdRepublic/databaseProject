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
                $error = "";
                if(isset($_SESSION["addMemberError"])){ 
                    $error = "<div class = 'error'>".$_SESSION['addMemberError']."</div>";
                    unset($_SESSION["addMemberError"]);
                }
                if(!isset($_SESSION["currentFriendGroup"])){
                    if($_POST["newGroupName"]==""){
                        $_SESSION["groupNameError"] = "Friendgroup cannot be NULL";
                        header("Location: friendgroup.php");  
                    }                  
                    else
                        $_SESSION["currentFriendGroup"]=$_POST["newGroupName"];
                }
                $friendGroup = $_SESSION["currentFriendGroup"];
                //checks if group alreaedy exist for user
                $cmd = "SELECT * FROM friendgroup WHERE username='$_SESSION[userSession]' AND group_name = $friendGroup";
                $statement = $conn->prepare($cmd);
                $statement->execute();
                $result = $statement->fetch();
                if($result){
                    $_SESSION["groupNameError"] = "You already have a friendgroup with the name $friendGroup";
                    header("Location: friendgroup.php");
                }
                //new friend group
                echo "Creating friendgroup: $friendGroup<br/>
                    <br/>
                    <span>Add User to $friendGroup</span>
                    <form action='back/registerMember.php' method='POST'>
                        <input name='FName' placeholder='First Name' type='text'/> 
                        <input name='LName' placeholder='Last Name' type='text'/> <br/> 
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
                        echo "<a href = 'back/registerSpecficMember.php?username=$result[username]&FName=$FName&LName=$LName'>{".$result[0]."} $FName $FName</a> <br/>" ;
                    }while($result = $statement->fetch());
                }
                
            ?>
        </div>
    </body>
</html>