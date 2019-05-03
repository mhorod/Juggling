<?php

if(!isset($_POST["login"]))
{
    $path = "http://i-be-jugglin.000webhostapp.com/dev/mainPage.php";
    header("location:$path");
}
session_start();
unset($_SESSION["logInError"]);

$ok = false;
$error = "";

$login = $_POST["login"];
$password = $_POST["password"];

$_SESSION["login"] = $login;
$_SESSION["password"] = $password;

$path = "../common";
require("$path/connectDB.php");
$table = "users";


$login = htmlentities($login,ENT_QUOTES,"UTF-8");
$login = mysqli_real_escape_string($mysqli,$login);

//Check if login exists
$query = sprintf("SELECT * FROM `$table` WHERE `login` = '%s'", $login);
$result = mysqli_query($mysqli, $query);
$exits = mysqli_num_rows($result);
$error = "Nieznany login";

if($exits)
{
    $password_hash = md5($password);
    $query = sprintf("SELECT * FROM `$table` WHERE `login` = '%s' AND `password` = '%s'", $login, $password_hash);
    $result = mysqli_query($mysqli, $query);
    $match = mysqli_num_rows($result);

    if($match)
    {
        echo "Logged in!";
        $userData = mysqli_fetch_assoc($result);
        $_SESSION["userID"] = $userData["id"];
        $_SESSION["userName"] = $userData["username"];
        $ok = true;
    }
    else
    {
        $error = "Niepoprawne hasło";
    }
}


$mysqli -> close();

if(!$ok)
{
    $_SESSION["logInError"] = $error;
    header("location:log-in-form.php");
}
else
{
    header("location:../");
}




?>