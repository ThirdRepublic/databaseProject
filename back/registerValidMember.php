<?php
    session_start();
    if(!isset($_SESSION["userSession"])){   
        header("Location: login.php");
    }
    $friendGroup = $_POST["friendGroup"];
    $FName = $_POST["FName"];
    $LName = $_POST["LName"];
    if($FName==""||$LName==""){
        $_SESSION["addMemberError"] = "Values cannot be NULL";
        header("Location: ../validFriendGroup.php?friendGroup=$friendGroup");
    }
    else{
        $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
        $cmd = "SELECT COUNT(*),username FROM person WHERE first_name = '$FName' AND last_name = '$LName'";
        $statement = $conn->prepare($cmd);
        $statement->execute();
        $result = $statement->fetch();
        if($result[0]==0){
            //user does not exist
            $_SESSION["addMemberError"] = "$FName $LName does not exist";
            header("Location: ../validFriendGroup.php?friendGroup=$friendGroup");
        }
        else
            if($result[0]==1||isset($_GET["username"])){
                //selected a specfic user with same fname/lname
                if(isset($_GET["username"])){
                    $userToAdd = $_GET["username"];
                }
                else
                    $userToAdd = $result['username'];
                //checks if user is adding himself
                if($userToAdd==$_SESSION["userSession"]){
                    $_SESSION["addMemberError"] = "You cannot add yourself";
                    header("Location: ../validFriendGroup.php?friendGroup=$friendGroup");
                }
                else{
                    //check if user already belongs to the friendgroup
                    $cmd = "SELECT * FROM member WHERE username = '$userToAdd' AND group_name = '$friendGroup'";
                    $statement = $conn->prepare($cmd);
                    $statement->execute();
                    $result = $statement->fetch();
                    if($result){
                        $_SESSION["addMemberError"] = "$FName $LName is already in the friendgroup: $friendGroup";
                        header("Location: ../validFriendGroup.php?friendGroup=$friendGroup");
                    }
                    else{
                        //add user 
                        $cmd = "INSERT INTO member VALUES('$userToAdd','$friendGroup','$_SESSION[userSession]')";
                        $statement = $conn->prepare($cmd);
                        $statement->execute();
                        $_SESSION["addMemberError"] = "$FName $LName added to friendgroup $friendGroup";
                        header("Location: ../validFriendGroup.php?friendGroup=$friendGroup");
                    }
                }
            }
            else{
                //Too many users with same first and last name which user did you mean?
                $_SESSION["addMemberError"] = "Which user did you mean?";
                header("Location: ../validFriendGroup.php?FName=$FName&LName=$LName&friendGroup=$friendGroup");
            }  
    }
?>
   