<?php
require 'conn/connection.php';
require 'src/User.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $email = $_POST["email"];

  $existingUser = User::loadUserByEmail($conn, $email);

  if ($existingUser != null) {
    
    echo "Ten email jest już zajęty! <br>";
    
  } else if ($_POST["pass1"] !== $_POST["pass2"]) {
    
    echo "Hasła się nie zgadzają! <br>";
    
  } else {
    
    echo "nowy user tworzony<br>";
    
    $user = new User();
    $user->setEmail($_POST["email"]);
    $user->setUsername($_POST["username"]);
    $user->setHashedPassword($_POST["pass1"]);
    $result = $user->saveToDB($conn);
    
    if ($result) {
      echo "Użytkownik " . $_POST["username"] . " zarejestrowany";
      $user->login();
      sleep(1);
      header("Location: /TwitterTW/index.php");
    }
    else {
      echo "Rejestracja nieudana. Spróbuj jeszcze raz.<br>";
      echo $conn->error . "<br>";
    }
  }
}

$formEmail = isset($_POST["email"]) ? $_POST["email"] : "";
$formUsername = isset($_POST["username"]) ? $_POST["username"] : "";

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
                <h2>Rejestracja</h2>
                email: <input type="email" name="email" 
                              value="<?php echo $formEmail ?>" required>
                <br><br>
                nick: <input type="text" name="username" 
                             value="<?php echo $formUsername ?>" required>
                <br><br>
                hasło: <input type="password" name="pass1" required>
                <br><br>
                powtórz hasło: <input type="password" name="pass2" required>
                <br><br>
                <input type="submit">
            </form>
            <br><br>
            <a href="/TwitterTW/login.php">Przejdź do strony logowania</a>
        </div>
    </body>
</html>