<?php 

require 'conn/connection.php';
require 'src/Tweet.php';
require 'src/User.php';

require 'includes/authorize.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $tweet = new Tweet();
  $tweet->setUserId($_SESSION["loggedUserId"]);
  $tweet->setText($_POST["text"]);
  $tweet->setCreationDate(date("Y-m-d H:i:s"));  
  $tweet->saveToDB($conn);
}

$allTweets = Tweet::loadAllTweets($conn);

?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Tweete-à-tweete</title>
</head>
<body>
    <div class="container">
        <form action="#" method="POST">
            Tweetnij co u Ciebie:<br>
            <textarea name="text" maxlength="140" required></textarea>
            <br>
            <input type="submit">
        </form>
        
        <?php 
          foreach ($allTweets as $tweet) {

            $id = $tweet->getId();
            $userId = $tweet->getUserId();
            $text = $tweet->getText();
            $creationDate = $tweet->getCreationDate();
            
            $user = User::loadUserById($conn, $userId);
            $name = $user->getUsername();
            
            echo "<a href='/TwitterTW/user.php?id=$userId'>$name</a> | $creationDate <br>";
            echo "$text<br>";
            echo "<small><a href='/TwitterTW/tweet.php?id=$id'>Zobacz komentarze</a></small>";
            echo "<hr>";           
          }
        ?>
    </div>
</body>
</html>