<?php
require 'conn/connection.php';
require 'src/User.php';
require 'src/Message.php';
require 'includes/authorize.php';

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
  
  $id = $_GET["id"];
  
  $message = Message::loadMessageById($conn, $id);
  $loggedUserId = $_SESSION["loggedUserId"];
  
  if (!$message || !($message->getReceiverId() == $loggedUserId 
                      || $message->getSenderId() == $loggedUserId)) {
    echo "Nie ma takiej wiadomości lub nie możesz jej zobaczyć <br>";
    exit();
  }
  
  $messText = $message->getText();
  $creationDate = $message->getCreationDate();
  
  if ($message->getReceiverId() == $loggedUserId) {
    
    $sender = User::loadUserById($conn, $message->getSenderId());
    $senderName = $sender->getUsername();  
    
    if (!$message->getIsRead()) {  
      $message->setIsRead(1);
      $message->saveToDB($conn);    
    }
  } 
  else {
    $receiver = User::loadUserById($conn, $message->getReceiverId());
    $receiverName = $receiver->getUsername();  
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
            if (isset($sender)) {
              echo "<b>Wiadomość od: 
              <a href='/TwitterTW/user.php?id=".$sender->getId()."'>$senderName</a></b><br>";
              
              echo "<p>$messText</p>";
            }
            else {
              echo "<b>Wiadomość do: 
              <a href='/TwitterTW/user.php?id=".$receiver->getId()."'>$receiverName</a></b><br>";
              
              echo "<p>$messText</p>";
            }
        ?>
    </div>
</body>
</html>