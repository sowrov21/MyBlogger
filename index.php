<?php
//header('Location:./login.php');
//header('Location:./backend/init.php');
//echo "Hello Blogger";
include_once './backend/init.php';

$db = Database::instance();

$db->prepare("SELECT * FROM `users`");