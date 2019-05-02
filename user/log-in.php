<?php

if(!isset($_POST["login"]))
{
    $path = "http://i-be-jugglin.000webhostapp.com/dev/mainPage.php";
    header("location:$path");
}

$login = $_POST["login"];
$password = $_POST["password"];
session_start();
$_SESSION["login"] = $login;
$_SESSION["password"] = $password;
$_SESSION["logInError"] = "Nieprawidłowy login lub hasło";

header("location:log-in-form.php");


?>