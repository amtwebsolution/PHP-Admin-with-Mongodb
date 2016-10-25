<?php
    @session_start();
    if(!(isset($_SESSION['adm_logged']) && ($_SESSION['adm_logged'] == true))){
        header("Location:index.php");
        exit;		              
    }   
?>

