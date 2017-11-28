<?php
    session_start();
    if(!isset($_SESSION["userSession"])){   
        header("Location: login.php");
    }
    $friendGroup = $_SESSION["currentFriendGroup"];
    $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
    if(isset($_GET["username"])){
        //selected a specfic user with same fname/lname
        $userToAdd = $_GET["username"];
        //checks if user is adding himself
        if($userToAdd==$_SESSION["userSession"]){
            $_SESSION["addMemberError"] = "You cannot add yourself";
            header("Location: ../newFriendGroup.php");
        }
        else{
            //add user and create friendgroup
            $cmd = "INSERT INTO friendgroup VALUES('$friendGroup','$_SESSION[userSession]',NULL)";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $cmd = "INSERT INTO member VALUES('$userToAdd','$friendGroup','$_SESSION[userSession]'),('$_SESSION[userSession]','$friendGroup','$_SESSION[userSession]')";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $_SESSION["addMemberError"] = "$_GET[FName] $_GET[LName] added to friendgroup $friendGroup";
            unset($_SESSION["currentFriendGroup"]);
            header("Location: ../validFriendGroup.php?friendGroup=$friendGroup");
        }
    }
?>
   