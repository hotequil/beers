<?php
    require_once "environment.php";

    $connection = new PDO("mysql:host=$server;dbname=$database", $user, $password);
?>
