<?php
    session_start();
    if(!isset($_SESSION["userSession"])){   
        header("Location: login.php");
    }
    $username = $_POST["username"];
    $contentId = $_POST["contentId"];
    if($username==""){
        $_SESSION["tagError"] = "Username cannot be NULL";
        header("Location: ../content.php?contentId=$contentId");
    }
    else{
        $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
        //check if tag already exist 
        $cmd = "SELECT * FROM tag WHERE username_tagger = '$_SESSION[userSession]' AND username_taggee = '$username'";
        $statement = $conn->prepare($cmd);
        $statement->execute();
        $result = $statement->fetch();
        if($result){
            if($result['status']==1){
                $_SESSION["tagError"] = "$username is already tagged.";
            }
            else{
                $_SESSION["tagError"] = "Tag request to $username is pending.";
            }
            header("Location: ../content.php?contentId=$contentId");
        }
        else{
            $cmd = "SELECT * FROM content WHERE id = $contentId";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            //check if item is visible to taggee
            $cmd = "SELECT * FROM share s JOIN member m WHERE s.group_name = m.group_name AND s.username = m.username_creator AND m.username = '$username' AND s.id = '$contentId'";
            $statement2 = $conn->prepare($cmd);
            $statement2->execute();
            $result2 = $statement2->fetch();
            if($result['public']==0&&!$result2){//private and not visible
                $_SESSION["tagError"] = "$username does not have permisson to view content.";
                header("Location: ../content.php?contentId=$contentId");
            }
            else{
                //insert into 
                //check if self tagging
                if($username == ($_SESSION["userSession"])){
                    $cmd = "INSERT INTO tag(id, username_tagger, username_taggee, status) VALUES ('$contentId','$_SESSION[userSession]','$username',1)";
                    $_SESSION["tagError"] = "Tag Successful.";
                }
                else{
                    $cmd = "INSERT INTO tag(id, username_tagger, username_taggee, status) VALUES ('$contentId','$_SESSION[userSession]','$username',0)";
                    $_SESSION["tagError"] = "Tag Request Sent.";
                }
                $statement = $conn->prepare($cmd);
                $statement->execute();
                echo "here";
                header("Location: ../content.php?contentId=$contentId");
            }
        }
    }
?>
   