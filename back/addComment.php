<?php
    session_start();
    if(!isset($_SESSION["userSession"])){   
        header("Location: login.php");
    }
    $comment = $_POST["comment"];
    $contentId = $_POST["contentId"];
    if($comment==""){
        $_SESSION["commentError"] = "Comment cannot be NULL";
        header("Location: ../content.php?contentId=$contentId");
    }
    else{
        $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", ""); 
        $cmd = "INSERT INTO comment(id, username, comment_text) VALUES ('$contentId','$_SESSION[userSession]','$comment')";
        $statement = $conn->prepare($cmd);
        $statement->execute();
        header("Location: ../content.php?contentId=$contentId");
    }
?>
   