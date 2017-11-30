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
            $cmd = "SELECT t.id, c.username AS postedBy, c.content_name, c.file_path, s.group_name, p.username, p.first_name, p.last_name FROM tag t JOIN person p JOIN share s JOIN content c WHERE t.id = c.id AND t.id = s.id AND t.username_tagger = p.username AND t.username_taggee = '$_SESSION[userSession]' AND t.status = '0'";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            if($result){
                echo "<h1>Pending Tags</h1>";
                do{
                    $cmd = "SELECT username, first_name, last_name FROM person WHERE username = $result[postedBy]";
                    $statement2 = $conn->prepare($cmd);
                    $statement2->execute();
                    $result2 = $statement2->fetch();
                    echo "
                    <div> 
                        <div>Tag Request By <b>$result[first_name] $result[last_name] (".$result['username'].")</b> on <a href = 'content.php?contentId=$result[id]'> $result[content_name]</a> <br/> Posted By: <b>$result[first_name] $result[last_name] (".$result['username'].")</b> to the <b>$result[group_name]</b> FriendGroup <br/> </div>
                        <img src='$result[file_path]' alt='$result[content_name]'>
                        <form action='back/updateTags.php' method='POST'> 
                            <input name='action' value='Accept' type='submit'>
                            <input name='action' value='Decline' type='submit'>
                            <input name='tagger' type='hidden' value='$result[username]'>
                            <input name='contentId' type='hidden' value='$result[id]'>
                        </form>
                    </div> <br/>
                    ";
                }while($result = $statement->fetch());
            }
            else{
                echo "<h1>You Don't Have Pending Tags</h1>";
            }
            //checks for accepted tags
            $cmd = "SELECT t.id, c.username AS postedBy, c.content_name, c.file_path, s.group_name, p.username, p.first_name, p.last_name FROM tag t JOIN person p JOIN share s JOIN content c WHERE t.id = c.id AND t.id = s.id AND t.username_tagger = p.username AND t.username_taggee = '$_SESSION[userSession]' AND t.status = '1'";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            if($result){
                echo "<h1>Accepted Tags</h1>";
                do{
                    $cmd = "SELECT username, first_name, last_name FROM person WHERE username = $result[postedBy]";
                    $statement2 = $conn->prepare($cmd);
                    $statement2->execute();
                    $result2 = $statement2->fetch();
                    echo "
                    <div> 
                        <div>Tag Request By <b>$result[first_name] $result[last_name] (".$result['username'].")</b> on <a href = 'content.php?contentId=$result[id]'> $result[content_name]</a> <br/> Posted By: <b>$result[first_name] $result[last_name] (".$result['username'].")</b> to the <b>$result[group_name]</b> FriendGroup <br/> </div>
                        <img src='$result[file_path]' alt='$result[content_name]'>
                        <form action='back/updateTags.php' method='POST'> 
                            <input name='action' value='Remove Tag' type='submit'>
                            <input name='tagger' type='hidden' value='$result[username]'>
                            <input name='contentId' type='hidden' value='$result[id]'>
                        </form>
                    </div> <br/>
                    ";
                }while($result = $statement->fetch());
            }
            else{
                echo "<h1>You Haven't Accepted Any Tags</h1>";
            }
            ?>
        </div>
    </body>
</html>