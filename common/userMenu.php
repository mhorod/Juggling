<?php
$dir = str_replace('\\', '/', __DIR__);
$root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$path = str_replace($root, '', $dir)."/..";

echo<<<END
<nav id = "user-menu">
    <div class = "menu-button"><a href = "$path">Blog</a></div>
    <div class = "menu-button"><a href = "$path/mainPage.php">Suwajka</a></div>
    <div class = "menu-button"><a href = "$path/user/log-in-form.php">Zaloguj</a></div>
    <div class = "menu-button"><a href = "$path/user/register-form.php">Zarejestruj</a></div>
</nav>

END;

?>