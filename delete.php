<?php
    require_once("./utils/connection.php");
    require_once("./utils/redirects.php");

    $id = intval($_REQUEST['id']);
    $statement = $connection -> prepare("DELETE FROM $table WHERE id=$id");

    try{
        $statement -> execute();

        toList("Beer deleted");
    } catch(Exception $error){
        showError($error);
    }
?>
