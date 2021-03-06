<?php

class User {

  private $id;
  private $username;
  private $hashedPassword;
  private $email;

  public function __construct() {
    $this->id = -1;
    $this->username = "";
    $this->email = "";
    $this->hashedPassword = "";
  }

  public function getId() {
    return $this->id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getHashedPassword() {
     return $this->hashedPassword;
  }
  
  public function setEmail($email) {
    $this->email = $email;
  }

  public function setUsername($username) {
    $this->username = $username;
  }

  public function setHashedPassword($password) {
    $this->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
  }

  public function saveToDB(mysqli $conn) {
    if ($this->id == -1) {
      $sql = "INSERT INTO User (email, username, hashed_password) VALUES"
              . "('$this->email', '$this->username', '$this->hashedPassword')";
      $result = $conn->query($sql);
      if ($result == true) {
        $this->id = $conn->insert_id;
        return true;
      }
    } else {
      $sql = "UPDATE User SET username='$this->username',
              email='$this->email',
              hashed_password='$this->hashedPassword'
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
      $sql = "DELETE FROM User WHERE id=$this->id";
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
  
  public function login() {
    $_SESSION["loggedUserId"] = $this->id;
  }

  static public function loadUserById(mysqli $conn, $id) {
    $sql = "SELECT * FROM User WHERE id=$id";
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $loadedUser = new User();
      $loadedUser->id = $row['id'];
      $loadedUser->username = $row['username'];
      $loadedUser->hashedPassword = $row['hashed_password']; //zwroc uwage na rozne nazewnictwa hashedpassword;
      $loadedUser->email = $row['email'];
      return $loadedUser;
    }
    return null;
  }
  
  static public function loadUserByEmail(mysqli $conn, $email) {
    $sql = "SELECT * FROM User WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $loadedUser = new User();
      $loadedUser->id = $row['id'];
      $loadedUser->username = $row['username'];
      $loadedUser->hashedPassword = $row['hashed_password']; //zwroc uwage na rozne nazewnictwa hashedpassword;
      $loadedUser->email = $row['email'];
      return $loadedUser;
    }
    return null;
  }

  static public function loadAllUsers(mysqli $conn) {
    $sql = "SELECT * FROM User";
    $ret = [];
    $result = $conn->query($sql);
    if ($result == true && $result->num_rows != 0) {
      foreach ($result as $row) {
        $loadedUser = new User();
        $loadedUser->id = $row['id'];
        $loadedUser->username = $row['username'];
        $loadedUser->hashedPassword = $row['hashed_password'];
        $loadedUser->email = $row['email'];
        $ret[] = $loadedUser;
      }
    }
    return $ret;
  }

}
