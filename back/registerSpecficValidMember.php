<?php
    session_start();
    if(!isset($_SESSION["userSession"])){   
        header("Location: login.php");
    }
    $friendGroup = $_GET["friendGroup"];
    $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
    if(isset($_GET["username"])){
        //selected a specfic user with same fname/lname
        $userToAdd = $_GET["username"];
        //checks if user is adding himself
        if($userToAdd==$_SESSION["userSession"]){
            $_SESSION["addMemberError"] = "You cannot add yourself";
            header("Location: ../validFriendGroup.php?friendGroup=$friendGroup");
        }else{
            //check if user already belongs to the friendgroup
            $cmd = "SELECT * FROM member WHERE username = '$userToAdd' AND group_name = '$friendGroup'";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            if($result){
                $_SESSION["addMemberError"] = "$_GET[FName] $_GET[LName] is already in the friendgroup: $friendGroup";
                header("Location: ../validFriendGroup.php?friendGroup=$friendGroup");
            }
            else{
                //add user 
                $cmd = "INSERT INTO member VALUES('$userToAdd','$friendGroup','$_SESSION[userSession]')";
                $statement = $conn->prepare($cmd);
                $statement->execute();
                $_SESSION["addMemberError"] = "$_GET[FName] $_GET[LName] added to friendgroup $friendGroup";
                header("Location: ../validFriendGroup.php?friendGroup=$friendGroup");
            }
        }
    }
?>
   