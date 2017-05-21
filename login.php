<?php 

require 'conn/connection.php';
require 'src/User.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $email = $_POST['email'];
  $password = $_POST['pass'];

  $user = User::loadUserByEmail($conn, $email);
  
  if ($user && password_verify($password, $user->getHashedPassword())) {
    $user->login();
    header("Location: /TwitterTW/index.php");
  }
  else {
    echo "Błędny login lub hasło :(";
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
        <form action="#" method="POST">
            <h2>Zaloguj się</h2>
            email: <input type="email" name="email" required>
            <br><br>
            hasło: <input type="password" name="pass" required>
            <br><br>
            <input type="submit">
        </form>
        <br><br>
        <a href="/TwitterTW/register.php">Nie masz konta? Zarejestruj się</a>
    </div>
</body>
</html>

<!--
html

formularz do 


//do logowania w pliku user.php;

public function login() {
$_SESSION[''] = $this->id;
}-->
