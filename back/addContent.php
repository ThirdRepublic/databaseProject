<?php
    session_start();
    if(!isset($_SESSION["userSession"])){   
        header("Location: login.php");
    }
    $name = $_POST["name"];
    $filePath = $_POST["file_path"];
    $isPublic = $_POST["isPublic"];
    if($isPublic == 'Public')
        $value = 1;
    else
        $value = 0;
    if($name==""||$filePath==""){
        $_SESSION["addContentError"] = "Values cannot be NULL";
        header("Location: ../manageContent.php");
    }
    else{
        $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
        //check if name already exist
        $cmd = "SELECT * FROM content WHERE username = '$_SESSION[userSession]' AND content_name = '$name'";
        $statement = $conn->prepare($cmd);
        $statement->execute();
        $result = $statement->fetch();
        if($result){
            $_SESSION["addContentError"] = "You already own a content with the name: <b>$name</b>.  Please select another name.";
            header("Location: ../manageContent.php");
        }
        else{
            $cmd = "INSERT INTO content(username, file_path, content_name, public) VALUES ('$_SESSION[userSession]','$filePath','$name',$value)";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            header("Location: ../manageContent.php");
        }
    }
?>
   