<?php

//Normalize path
$dir = str_replace('\\', '/', __DIR__);
$root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$path = str_replace($root, '', $dir)."/..";


echo<<<END
<nav id = "user-menu">
    <a class = "menu-button" href = "$path">Blog</a>
    <a class = "menu-button" href = "$path/mainPage.php">Suwajka</a>
END;

if(isset($_SESSION["userID"]))
{
    echo<<<END
    <a class = "menu-button" href = "$path/user/account.php">Konto</a>
    <a class = "menu-button" href = "$path/user/logout.php">Wyloguj</a>
END;
}
else 
{
    echo<<<END
    <a class = "menu-button" href = "$path/user/log-in-form.php">Zaloguj</a>
    <a class = "menu-button" href = "$path/user/register-form.php">Zarejestruj</a>
END;
}

echo "</nav>";

?>