<?php

session_start();

unset($_SESSION["loggedUserId"]);

header("Location: /TwitterTW/login.php");
