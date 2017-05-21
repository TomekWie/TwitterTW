<?php
require 'conn/connection.php';
require 'src/Tweet.php';
require 'src/User.php';
require 'src/Comment.php';
require 'includes/authorize.php';

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
  
  $id = $_GET["id"];

  if ($_SERVER['REQUEST_METHOD']=="POST") {
    $newComment = new Comment();
    $newComment->setText($_POST['text']);
    $newComment->setCreationDate(date("Y-m-d H:i:s"));
    $newComment->setTweetId($id);
    $newComment->setUserId($_SESSION["loggedUserId"]);
    $newComment->saveToDB($conn);
  } 

  $tweet = Tweet::loadTweetById($conn, $id);
  
  if (!$tweet) {
    echo "Nie ma takiego tweeta <br>";
    exit();
  }
  
  $text = $tweet->getText();
  $creationDate = $tweet->getCreationDate();
  $userId = $tweet->getUserId();
  
  $user = User::loadUserById($conn, $userId);
  $username = $user->getUsername();
  
  $comments = Comment::loadAllCommentsByTweetId($conn, $id);
 
}

?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Tweete-à-tweete</title>
</head>
<body>
    <div class="container">
        <?php             
            echo "$username | $creationDate <br>";
            echo "$text<br>";
            echo "<hr>";  
        ?>            
        <h2>Komentarze:</h2>
        <form action="" method="POST">
            <textarea name="text" placeholder="Wpisz swój komentarz" required></textarea>
            <input type="submit">
        </form>
        <?php
            foreach($comments as $comment){
              echo $comment->getText()."<br>";
              echo $comment->getCreationDate()."<br>";
              $author = User::loadUserById($conn, $comment->getUserId());
              $authorId = $author->getId();
              $authorName = $author->getUsername();
              echo "<a href='/TwitterTW/user.php?id=$authorId'> $authorName</a><hr>";
            }
        ?>
    </div>
</body>
</html>