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
            if(isset($_SESSION["tagError"])){
                $error = "<div class = 'error'>".$_SESSION['tagError']."</div>";
                unset($_SESSION["tagError"]);
            }   
            $contentId = $_GET["contentId"];
            $isPublicPost = False;
            $conn = new PDO("mysql:host=localhost;dbname=databaseproject", "root", "");
            //check if public post or user's content
            $cmd = "SELECT * FROM content WHERE id = $contentId AND (public = 1 OR username = '$_SESSION[userSession]')";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            //check if valid permission to view content
            if(!$result){
                //checks if content is shared with user
                $cmd = "SELECT * FROM share s JOIN member m WHERE s.id = $contentId AND s.group_name = m.group_name AND s.username = m.username_creator AND m.username = $_SESSION[userSession]";
                $statement = $conn->prepare($cmd);
                $statement->execute();
                $result = $statement->fetch();
                if(!$result){
                    $_SESSION["addContentError"] = "You do not have access to the content";
                    header("Location: index.php");
                }
            }
            else{
                $isPublicPost = True;
            }
            $cmd = "SELECT * FROM content WHERE id = $contentId";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            echo "
            <figure>
                <div> <br/> $result[username]: <br/>";
                echo substr($result['timest'],0,strpos($result['timest'],' ')) . "<br/>" . substr($result['timest'],strpos($result['timest'],' '));
                echo "</div>
                    <img src='$result[file_path]' alt='$result[content_name]'>   
                <figcaption>$result[content_name]</figcaption>
            </figure>";
            //checks if user owns content and if content is private to be shared
            if($result['username']==$_SESSION["userSession"] && $result['public']==0){
                echo "
                <form action='shareContent.php' method='POST'>
                    <input name='contentId' type='hidden' value='$contentId'>
                    <input value = 'share' type='submit'>
                </form> <br/>
                ";
            }
            //checks for tagged users
            $cmd = "SELECT p.username, p.first_name, p.last_name FROM tag t JOIN person p WHERE t.username_taggee = p.username AND id = '$contentId' AND status = '1'";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            if($result){
                echo "<h1>Tagged Users</h1>";
                do{
                    echo "
                    <div> $result[first_name] $result[last_name] (".$result['username'].") </div>
                    ";
                }while($result = $statement->fetch());
            }
            echo "
                <h3>Tag user</h3>
                <form action='back/tagUser.php' method='POST'>
                    <input name='username' placeholder='Username' type='text'/>  
                    <input name='contentId' value='$contentId' type='hidden'/>
                    <input value = 'Tag User' type='submit'>
                </form> $error
            ";
            //checks for comments
            $cmd = "SELECT c.timest, c.comment_text, p.username, p.first_name, p.last_name FROM comment c JOIN person p WHERE c.id = '$contentId' AND c.username = p.username ORDER BY c.timest DESC";
            $statement = $conn->prepare($cmd);
            $statement->execute();
            $result = $statement->fetch();
            if($result){
                echo "<h1>Comments</h1>";
                do{
                    echo "
                    <div> $result[timest] &nbsp&nbsp $result[first_name] $result[last_name] (".$result['username'].") : $result[comment_text]</div>
                    ";
                }while($result = $statement->fetch());
            }
            ?>
        </div>
    </body>
</html>