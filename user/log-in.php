<?php
/*
    Receive data and attempt logging in
*/

//This file shouldn't be opened in browser and should only accecpt POST requests
if(!isset($_POST["login"]))
{
    $path = "http://i-be-jugglin.000webhostapp.com/dev/mainPage.php";
    header("location:$path");
}

$path = "../common";
require("$path/connectDB.php");
$usersTable = "users";

session_start();
unset($_SESSION["logInError"]);

$ok = false;
$error = "";

$login = $_POST["login"];
$password = $_POST["password"];
$_SESSION["login"] = $login;

//Make sure login won't do any harm to server
$login = htmlentities($login,ENT_QUOTES,"UTF-8");
$login = mysqli_real_escape_string($mysqli,$login);

//Check if login exists
$query = sprintf("SELECT * FROM `$usersTable` WHERE `login` = '%s'", $login);
$result = mysqli_query($mysqli, $query);
$exits = mysqli_num_rows($result);
$error = "Nieznany login";

if($exits)
{
    //If login exits, check if password is correct
    $password_hash = md5($password);
    $query = sprintf("SELECT * FROM `$usersTable` WHERE `login` = '%s' AND `password` = '%s'", $login, $password_hash);
    $result = mysqli_query($mysqli, $query);
    $match = mysqli_num_rows($result);

    if($match)
    {
        //If logged in succesfully - set that in session
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
    header("location:../user/account.php");
}
?>