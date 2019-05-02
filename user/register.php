<?php

if(!isset($_POST["register"]))
{
    $path = "http://i-be-jugglin.000webhostapp.com/dev/mainPage.php";
    header("location:$path");
}

session_start();

$login = $_POST["login"];
$name = $_POST["username"];
$password = $_POST["password"];
$repeat = $_POST["repeat"];

$_SESSION["login"] = $login;
$_SESSION["username"] = $name;

$ok = false;
$error = "";


if(strlen($login) < 3 || strlen($login) > 20)
{
    $error = "Niepoprawna długość loginu";
    //Login has incorrect length
}
else if(strlen($name) < 3 || strlen($name) > 20)
{
    $error = "Niepoprawna długość nazwy użytkownika";
    //Username has incorrect length
}
else if(strlen($password) < 8)
{
    $error = "Hasło musi mieć minimum 8 znaków";
    //Password is too short
}
else if($password != $repeat)
{
    $error = "Hasła nie są identyczne";
    //Passwords don't match
}
else
{
    unset($_SESSION["registerError"]);
    $ok = true;
    $path = $_SERVER['DOCUMENT_ROOT']."/Tricks/common/";
    require("$path/connectDB.php");
    $table = "users";
    //Register
}



if(!$ok)
{
    $_SESSION["registerError"] = $error;
    header("location:register-form.php");
}
else
    header("location:http://i-be-jugglin.000webhostapp.com/dev/mainPage.php");
?>