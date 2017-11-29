<?php
    session_start();
    if(!isset($_SESSION["userSession"])){   
        header("Location: login.php");
    }
    $group = $_POST["shareWith"];
    $contentId = $_POST["contentId"];
    $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");    
    $cmd = "INSERT INTO share (id, group_name, username) VALUES ('$contentId', '$group', '$_SESSION[userSession]')";
    $statement = $conn->prepare($cmd);
    $statement->execute();
    $_SESSION["contentIdSession"] = $contentId;
    header("Location: ../shareContent.php");
?>
    