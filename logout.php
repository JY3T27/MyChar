<?php
session_start();
    if(isset($_SESSION["UID"])){
        unset($_SESSION["UID"]);
        unset($_SESSION["role"]);
        header("location:index.php");
    }
?>