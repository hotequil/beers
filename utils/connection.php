<?php
    require_once("./utils/environment.php");

    $connection = new PDO("mysql:host=$server;dbname=$database", $user, $password);
?>
