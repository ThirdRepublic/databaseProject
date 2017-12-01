<?php
    session_start();
    $username = $_POST["username"];               
    $password = $_POST["password"];
    $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
    if($username==null || $password==null){
        $_SESSION["loginError"] = "You cannot leave any field blank.";
        header("Location: ../login.php");       
    }
    else{
        $cmd = "SELECT password FROM person WHERE username='$username'";
        $statement = $conn->prepare($cmd);
        $statement->execute();
        $result = $statement->fetch();
        $storedPassword = $result["password"]; 
        if($result && password_verify($password, $storedPassword)){
            $_SESSION["userSession"] = strtoupper($username);
            header("Location: ../index.php");
        }
        else{
            $_SESSION["loginError"] = "Not a valid account."; 
            header("Location: ../login.php");                 
        }   
    }
?>