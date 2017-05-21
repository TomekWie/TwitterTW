<?php
require 'conn/connection.php';
require 'src/Tweet.php';
require 'src/User.php';
require 'src/Message.php';


require 'includes/authorize.php';

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {

  $id = $_GET["id"];

  $user = User::loadUserById($conn, $id);

  if (!$user) {
    echo "Nie ma takiego użytkownika <br>";
    exit();
  }

  $username = $user->getUsername();

  $userTweets = Tweet::loadAllTweetsByUserId($conn, $id);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $message = new Message();
    $message->setText($_POST["text"]); 
    $message->setSenderId($_SESSION["loggedUserId"]); 
    $message->setReceiverId($id); 
    $message->setCreationDate(date("Y-m-d H:i:s")); 
    $message->setIsRead(0); 
    $message->saveToDB($conn);
  }
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
echo "<h1>$username</h1>";
if ($_SESSION['loggedUserId'] != $id) {
  echo "<p>Wyślij wiadomość:</p>";
  echo "
              <form action='' method='POST'>
                <textarea name='text' required></textarea><br>
                <button type='submit'>Wyślij</button>
              </form>
              <br>
            ";
}


foreach ($userTweets as $tweet) {

  $tweetId = $tweet->getId();
  $userId = $tweet->getUserId();
  $text = $tweet->getText();
  $creationDate = $tweet->getCreationDate();

  echo "$username | $creationDate <br>";
  echo "$text<br>";
  echo "<small><a href='/TwitterTW/tweet.php?id=$tweetId'>Zobacz komentarze</a></small>";

  echo "<hr>";
}
?>
        </div>
    </body>
</html>