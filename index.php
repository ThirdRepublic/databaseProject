<!DOCTYPE html>
<html>
    <head>
        <title>PriCoSha</title>
        <style>
        </style>
        <link rel = "stylesheet" href = "back/header.css">
    </head>
    <body>
        <?php include "back/header.php"?>
        <div id = "main">
            <?php
            session_start();
            $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
            $error = "";
            if(isset($_SESSION["userSession"])){  
                if(isset($_SESSION["addContentError"])){
                    $error = "<div class = 'error'>".$_SESSION['addContentError']."</div> <br/>";
                    unset($_SESSION["addContentError"]);
                } 
                $cmd = "SELECT * FROM person WHERE username = '$_SESSION[userSession]'";
                $statement = $conn->prepare($cmd);
                $statement->execute();
                $result = $statement->fetch();
                echo "$error <h3>Welcome, $result[first_name] $result[last_name] (".$_SESSION["userSession"].")</h3> 
                    <h1>Feed</h1>
                ";
            }
            else{
                header("Location: login.php");
            }
            if(isset($_SESSION["currentFriendGroup"])){
                unset($_SESSION["currentFriendGroup"]);
            }
            if(isset($_SESSION["contentIdSession"])){
                unset($_SESSION["contentIdSession"]);
            }
            $cmd = "SELECT DISTINCT c.id, c.timest, c.username, c.content_name, c.file_path, p.first_name, p.last_name FROM content c JOIN person p WHERE c.username = p.username AND (c.username = '$_SESSION[userSession]' OR public = 1 OR id IN (SELECT c.id FROM member m JOIN share s JOIN content c WHERE m.group_name = s.group_name AND m.username_creator = s.username AND m.username = '$_SESSION[userSession]' AND s.id = c.id)) ORDER BY c.timest DESC";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            if($result){
                do{
                    echo "
                    <figure>
                        <div><b>$result[first_name] $result[last_name] (".$result['username'].")</b></div><div>";
                        echo substr($result['timest'],0,strpos($result['timest'],' ')) . "<br/>" . substr($result['timest'],strpos($result['timest'],' '));
                        echo "</div>
                        <a href= 'content.php?contentId=$result[id]'> 
                            <img src='$result[file_path]' alt='$result[content_name]'>
                        </a>    
                        <figcaption>$result[content_name]</figcaption>
                    </figure> 
                    ";
                }while($result = $statement->fetch());
            }
            ?>
        </div>
    </body>
</html>