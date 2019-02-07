<?php
session_start();

// Vérification Login et redirection...
if( empty($_SESSION) && $page != 'login' ){
    header('Location: login.php'); 
}

// Configuration générale


// Variables liées à la connexion SQL:
        $sql_host = 'localhost';
       $sql_admin = 'root';
    $sql_password = 'root';
    $sql_bdd_name = 'administrator';

// Connexion MySQLi Orientée Object:
    static $mysqli;
    $mysqli = new mysqli($sql_host, $sql_admin, $sql_password, $sql_bdd_name);
    $mysqli->select_db($sql_bdd_name);
    $mysqli->set_charset('utf8'); // Forcer le passage en UTF-8
?>