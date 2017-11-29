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
            $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
            $cmd = "SELECT t.id, c.username AS postedBy, c.content_name, s.group_name, p.username, p.first_name, p.last_name FROM tag t JOIN person p JOIN share s JOIN content c WHERE t.id = c.id AND t.id = s.id AND t.username_tagger = p.username AND t.username_taggee = '$_SESSION[userSession]' AND t.status = '0'";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            echo "<h1>Pending Tags</h1>";
            if($result){
                do{
                    echo "
                    <div> 
                        <div>Tag Request By $result[first_name] $result[last_name] (".$result['username'].") on <a href = 'content.php?contentId=$result[id]'> $result[content_name]</a> posted by $result[postedBy] to the $result[group_name] FriendGroup <br/> </div>
                        <form action='back/updateTags.php' method='POST'> 
                            <input name='action' value='Accept' type='submit'>
                            <input name='action' value='Decline' type='submit'>
                            <input name='tagger' type='hidden' value='$result[username]'>
                        </form>
                    </div> <br/>
                    ";
                }while($result = $statement->fetch());
            }
            ?>
        </div>
    </body>
</html>