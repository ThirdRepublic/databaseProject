<?php
    session_start();
    if(!isset($_SESSION["userSession"])){   
        header("Location: login.php");
    }
    $action = $_POST["action"];
    $tagger = $_POST["tagger"];
    $contentId = $_POST["contentId"];
    $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
    if($action == "Accept"){
        $cmd = "UPDATE tag SET status = 1 WHERE username_tagger = '$tagger' AND username_taggee = '$_SESSION[userSession]' AND id = '$contentId'";
    }
    else
        $cmd = "DELETE FROM tag WHERE username_tagger = '$tagger' AND username_taggee = '$_SESSION[userSession]' AND id = '$contentId'";
    $statement = $conn->prepare($cmd);
    $statement->execute();
    $result = $statement->fetch();
    header("Location: ../manageTags.php");
?>
    