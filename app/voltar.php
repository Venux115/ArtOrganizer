<?php 
    session_start();
    require_once "conexao.php";

    unset($_SESSION['id_pasta']);
    header("location:home.php");
?>