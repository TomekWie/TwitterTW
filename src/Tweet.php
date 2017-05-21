<?php

class Tweet 
{
  
  private $id;
  private $userId;
  private $text;
  private $creationDate;
  
  public function __construct()
  {
    $this->id = -1;
    $this->userId = 0;
    $this->text = "";
    $this->creationDate = "";
  }

  public function getId() {
    return $this->id;
  }

  public function getUserId() {
    return $this->userId;
  }

  public function getText() {
    return $this->text;
  }

  public function getCreationDate() {
    return $this->creationDate;
  }

  public function setUserId($userId) {
    $this->userId = $userId;
  }

  public function setText($text) {
    $this->text = $text;
  }

  public function setCreationDate($creationDate) {
    $this->creationDate = $creationDate;
  }

public function saveToDB(mysqli $conn) {
    if ($this->id == -1) {
      $sql = "INSERT INTO Tweet (user_id, text, creation_date) VALUES"
              . "('$this->userId', '$this->text', '$this->creationDate')";
      $result = $conn->query($sql);
      if ($result == true) {
        $this->id = $conn->insert_id;
        return true;
      } else
      {
        echo $conn->error;
      }
    } else {
      $sql = "UPDATE Tweet SET user_id='$this->userId',
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

  public function delete(mysqli $conn) {
    if ($this->id != -1) {
      $sql = "DELETE FROM Tweet WHERE id=$this->id";
      $result = $conn->query($sql);
      if ($result == true) {
        $this->id = -1;
        return true;
      } else {
      return false;
      }
    }
    return true;
  }

  static public function loadTweetById(mysqli $conn, $id) {
    $sql = "SELECT * FROM Tweet WHERE id=$id ORDER BY creation_date DESC";
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $loadedTweet = new Tweet();
      $loadedTweet->id = $row['id'];
      $loadedTweet->userId = $row['user_id'];
      $loadedTweet->text = $row['text'];
      $loadedTweet->creationDate = $row['creation_date'];
      return $loadedTweet;
    }
    return null;
  }

  static public function loadAllTweets(mysqli $conn) {
    $sql = "SELECT * FROM Tweet ORDER BY creation_date DESC";
    $ret = [];
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows != 0) {
      foreach ($result as $row) {
        $loadedTweet = new Tweet();
        $loadedTweet->id = $row['id'];
        $loadedTweet->userId = $row['user_id'];
        $loadedTweet->text = $row['text'];
        $loadedTweet->creationDate = $row['creation_date'];
        $ret[] = $loadedTweet;
      }
    }
    return $ret;
  }
  
  static public function loadAllTweetsByUserId(mysqli $conn, $userId) {
    $sql = "SELECT * FROM Tweet WHERE user_id=$userId ORDER BY creation_date DESC";
    $ret = [];
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows != 0) {
      foreach ($result as $row) {
        $loadedTweet = new Tweet();
        $loadedTweet->id = $row['id'];
        $loadedTweet->userId = $row['user_id'];
        $loadedTweet->text = $row['text'];
        $loadedTweet->creationDate = $row['creation_date'];
        $ret[] = $loadedTweet;
      }
    }
    return $ret;
  }
}