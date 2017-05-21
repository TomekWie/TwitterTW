<?php 

require 'conn/connection.php';
require 'src/User.php';
require 'src/Message.php';
require 'includes/authorize.php';

$userId = $_SESSION['loggedUserId'];

$receivedMess = Message::loadAllMessagesByReceiverId($conn, $userId);



$sentMess = Message::loadAllMessagesBySenderId($conn, $userId);
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Tweete-à-tweete</title>
    <style>
        div.unread {
          background: #e5e5e5;
        }
    </style>
</head>
<body>
<?php

echo"<h3> Wiadomości odebrane </h3>";
foreach ($receivedMess as $mess) {
  $divClass = $mess->getIsRead() ? "" : "unread";
  
  echo "<div class='$divClass'>";
  echo $mess->getCreationDate()."<br>";
  $sender = User::loadUserById($conn, $mess->getSenderId());
  $senderName = $sender->getUsername();
  echo "Od: <a href='/TwitterTW/user.php?id=".$sender->getId()."'>$senderName</a><br>";
  echo substr($mess->getText(),0,30)."... "
          . "<a href='/TwitterTW/message.php?id=".$mess->getId()."'>Przeczytaj</a><br><hr>";
  echo "</div>";

}

echo"<h3> Wiadomości wysłane </h3>";
foreach ($sentMess as $mess) {
  
  $divClass = $mess->getIsRead() ? "" : "unread";
  
  echo "<div class='$divClass'>";
  echo $mess->getCreationDate()."<br>";
  $receiver = User::loadUserById($conn, $mess->getReceiverId());
  $receiverName = $receiver->getUsername();
  echo "Do: <a href='/TwitterTW/user.php?id=".$receiver->getId()."'>$receiverName</a><br>";
  echo substr($mess->getText(),0,30)."... "
          . "<a href='/TwitterTW/message.php?id=".$mess->getId()."'>Przeczytaj</a><br><hr>";
  echo "</div>";
}

?>



</body>
</html>
