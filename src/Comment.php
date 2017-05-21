<?php

class Comment {
  
  private $id;
  private $tweetId;
  private $userId;
  private $creationDate;
  private $text;
  
  public function __construct() {
    
    $this->id = -1;
    $this->tweetId = 0;
    $this->userId = 0;
    $this->creationDate = "";
    $this->text = "";
    
  }
  
  public function getId() {
    return $this->id;
  }

  public function getTweetId() {
    return $this->tweetId;
  }

  public function getUserId() {
    return $this->userId;
  }

  public function getCreationDate() {
    return $this->creationDate;
  }

  public function getText() {
    return $this->text;
  }

  public function setTweetId($tweetId) {
    $this->tweetId = $tweetId;
  }

  public function setUserId($userId) {
    $this->userId = $userId;
  }

  public function setCreationDate($creationDate) {
    $this->creationDate = $creationDate;
  }

  public function setText($text) {
    $this->text = $text;
  }
  
  public function saveToDB(mysqli $conn) {
    if ($this->id == -1) {
      $sql = "INSERT INTO Comment (user_id, tweet_id, text, creation_date) VALUES"
              . "('$this->userId', '$this->tweetId','$this->text', '$this->creationDate')";
      $result = $conn->query($sql);
      if ($result == true) {
        $this->id = $conn->insert_id;
        return true;
      } else
      {
        echo $conn->error;
      }
    } else {
      $sql = "UPDATE Comment SET
              user_id='$this->userId',
              tweet_id='$this->tweetId',
              text='$this->text',
              creation_date='$this->creationDate'
              WHERE id=$this->id";
      $result = $conn->query($sql);
      if ($result == true) {
        return true;
      }
    }
    return false;
  }

  static public function loadCommentById(mysqli $conn, $id) {
    $sql = "SELECT * FROM Comment WHERE id=$id ORDER BY creation_date DESC";
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $loadedComment = new Comment();
      $loadedComment->id = $row['id'];
      $loadedComment->userId = $row['user_id'];
      $loadedComment->tweetId = $row['tweet_id'];
      $loadedComment->text = $row['text'];
      $loadedComment->creationDate = $row['creation_date'];
      return $loadedComment;
    }
    return null;
  }
  
  static public function loadAllCommentsByTweetId(mysqli $conn, $tweetId) {
    $sql = "SELECT * FROM Comment WHERE tweet_id=$tweetId ORDER BY creation_date DESC";
    $ret = [];
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows != 0) {
      foreach ($result as $row) {
        $loadedComment = new Comment();
        $loadedComment->id = $row['id'];
        $loadedComment->userId = $row['user_id'];
        $loadedComment->tweetId = $row['tweet_id'];
        $loadedComment->text = $row['text'];
        $loadedComment->creationDate = $row['creation_date'];
        $ret[] = $loadedComment;
      }
    }
    return $ret;
  }
  
}