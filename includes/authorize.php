<?php

session_start();

if (!isset($_SESSION["loggedUserId"]))
{
  header("Location: /TwitterTW/login.php");
}
else
{
  echo "<a href='/TwitterTW/logout.php'>Wyloguj się</a><br>";
}