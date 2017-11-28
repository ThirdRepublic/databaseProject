<?php
    session_start();
    $username = $_POST["username"];               
    $password = $_POST["password"];
    $FName = $_POST["FName"];
    $LName = $_POST["LName"];
    $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
    if($username==null || $password==null || $FName==null || $LName==null){
        $_SESSION["registerError"] = "You cannot leave any field blank.";
        header("Location: ../register.php"); 
    }
    else{
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement = $conn->prepare("SELECT username FROM person WHERE username = '$username'");
        $statement->execute();
        if(($statement->fetch()) == false){
            $statement = $conn->prepare("INSERT INTO person VALUES ('$username','$hashedPassword','$FName', '$LName')");
            $statement->execute();
            $_SESSION["loginError"] = "Account created succesfully.";
            header("Location: ../login.php");
        }
        else{
            $_SESSION["registerError"] = "Username is already used.";
            header("Location: ../register.php"); 
        } 
    }    
?>
                   