<?php


$serverName="localhost";
$userName="root";
$password="coderslab";
$baseName="Warsztat2";

$conn = new mysqli($serverName,$userName, $password, $baseName);
$conn->set_charset("utf8");

if ($conn->connect_error) {
  die("Blad: " . $conn->connect_error);
}
echo "Polaczono<br>";