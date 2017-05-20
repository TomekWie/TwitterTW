<?php


$serverName="localhost";
$userName="root";
$password="coderslab";
$baseName="Warsztat2";

$conn = new mysqli($serverName,$userName, $password, $baseName);

if ($conn->connect_error) {
  die("Blad: " . $conn->connect_error);
}
echo "Polaczono";