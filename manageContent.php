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
            if(!isset($_SESSION["userSession"])){   
                header("Location: login.php");
            }
            if(isset($_SESSION["currentFriendGroup"])){
                    unset($_SESSION["currentFriendGroup"]);
            }
            if(isset($_SESSION["contentIdSession"])){
                unset($_SESSION["contentIdSession"]);
            }
            $error = "";
            if(isset($_SESSION["addContentError"])){   
                $error = "<div class = 'error'>".$_SESSION['addContentError']."</div> <br/>";
                unset($_SESSION["addContentError"]);
            }
            $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
            echo "<span>Create New Content</span>
                <form action='back/addContent.php' method='POST'>
                    <input name='name' type='text' placeholder='Content Name'> <br/> 
                    <input name='file_path' type='text' placeholder='File Path'> <br/> 
                    <input name='isPublic' type='radio' value='Public'> Public <br/>
                    <input name='isPublic' type='radio' value='Private' checked> Private <br/>
                    <input type='submit'>
                </form> <br/> $error
                ";
            //loads all of user's posted content     
            $cmd = "SELECT id, timest, content_name, file_path FROM content WHERE username = '$_SESSION[userSession]' ORDER BY timest DESC";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            if($result){
                do{
                    echo "
                    <figure>
                        <div> Posted: <br/>";
                        echo substr($result['timest'],0,strpos($result['timest'],' ')) . "<br/>" . substr($result['timest'],strpos($result['timest'],' '));
                        echo "</div>
                        <a href= 'content.php?contentId=$result[id]'> 
                            <img src='$result[file_path]' alt='$result[content_name]'>
                        </a>    
                        <figcaption>$result[content_name]</figcaption>
                    </figure> <br/>
                    ";
                }while($result = $statement->fetch());
            }
            ?>
        </div>
    </body>
</html>