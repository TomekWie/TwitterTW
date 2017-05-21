<?php

class Message 
{
  
  private $id;
  private $senderId;
  private $receiverId;
  private $text;
  private $creationDate;
  private $isRead;
  
  public function __construct()
  {
    $this->id = -1;
    $this->senderId = 0;
    $this->receiverId = 0;
    $this->text = "";
    $this->creationDate = "";
    $this->isRead = 0;
  }

  public function getId() {
    return $this->id;
  }

  public function getSenderId() {
    return $this->senderId;
  }

  public function getReceiverId() {
    return $this->receiverId;
  }

  public function getText() {
    return $this->text;
  }

  public function getCreationDate() {
    return $this->creationDate;
  }

  public function getIsRead() {
    return $this->isRead;
  }


  public function setSenderId($senderId) {
    $this->senderId = $senderId;
  }

  public function setReceiverId($receiverId) {
    $this->receiverId = $receiverId;
  }

  public function setText($text) {
    $this->text = $text;
  }

  public function setCreationDate($creationDate) {
    $this->creationDate = $creationDate;
  }

  public function setIsRead($isRead) {
    $this->isRead = $isRead;
  }
  
public function saveToDB(mysqli $conn) {
    if ($this->id == -1) {
      $sql = "INSERT INTO Message (sender_id, receiver_id, text, creation_date, is_read) VALUES"
              . "('$this->senderId', '$this->receiverId', '$this->text', '$this->creationDate', '$this->isRead')";
      $result = $conn->query($sql);
      if ($result == true) {
        $this->id = $conn->insert_id;
        return true;
      } else
      {
        echo $conn->error;
      }
    } else {
      $sql = "UPDATE Message SET 
              sender_id='$this->senderId',
              receiver_id='$this->receiverId',
              text='$this->text',
              creation_date='$this->creationDate',
              is_read='$this->isRead'
              WHERE id=$this->id";
      $result = $conn->query($sql);
      if ($result == true) {
        return true;
      }
    }
    return false;
  }


  static public function loadMessageById(mysqli $conn, $id) {
    $sql = "SELECT * FROM Message WHERE id=$id ORDER BY creation_date DESC";
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $loadedMessage = new Message();
      $loadedMessage->id = $row['id'];
      $loadedMessage->senderId = $row['sender_id'];
      $loadedMessage->receiverId = $row['receiver_id'];
      $loadedMessage->text = $row['text'];
      $loadedMessage->creationDate = $row['creation_date'];
      $loadedMessage->isRead = $row['is_read'];
      return $loadedMessage;
    }
    return null;
  }

  
  static public function loadAllMessagesBySenderId(mysqli $conn, $senderId) {
    $sql = "SELECT * FROM Message WHERE sender_id=$senderId ORDER BY creation_date DESC";
    $ret = [];
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows != 0) {
      foreach ($result as $row) {
        $loadedMessage = new Message();
        $loadedMessage->id = $row['id'];
        $loadedMessage->senderId = $row['sender_id'];
        $loadedMessage->receiverId = $row['receiver_id'];
        $loadedMessage->text = $row['text'];
        $loadedMessage->creationDate = $row['creation_date'];
        $loadedMessage->isRead = $row['is_read'];
        $ret[] = $loadedMessage;
      }
    }
    return $ret;
  }
  
   static public function loadAllMessagesByReceiverId(mysqli $conn, $receiverId) {
    $sql = "SELECT * FROM Message WHERE receiver_id=$receiverId ORDER BY creation_date DESC";
    $ret = [];
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows != 0) {
      foreach ($result as $row) {
        $loadedMessage = new Message();
        $loadedMessage->id = $row['id'];
        $loadedMessage->senderId = $row['sender_id'];
        $loadedMessage->receiverId = $row['receiver_id'];
        $loadedMessage->text = $row['text'];
        $loadedMessage->creationDate = $row['creation_date'];
        $loadedMessage->isRead = $row['is_read'];
        $ret[] = $loadedMessage;
      }
    }
    return $ret;
  }
}