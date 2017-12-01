<?php
    session_start();
    if(!isset($_SESSION["userSession"])){   
        header("Location: login.php");
    }
    $timestamp = $_POST["timestamp"];
    $contentId = $_POST["contentId"];
    $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", ""); 
    $cmd = "DELETE FROM comment WHERE id = '$contentId' AND username = '$_SESSION[userSession]' AND timest = '$timestamp'";
    $statement = $conn->prepare($cmd);
    $statement->execute();
    header("Location: ../content.php?contentId=$contentId");

?>
   