<?php
$path = "http://i-be-jugglin.000webhostapp.com/dev";
echo<<<END
<nav id = "user-menu">
    <div class = "menu-button"><a href = "$path/">Blog</a></div>
    <div class = "menu-button"><a href = "$path/mainPage.php">Suwajka</a></div>
    <div class = "menu-button"><a href = "$path/user/log-in-form.php">Zaloguj</a></div>
    <div class = "menu-button"><a href = "$path/user/register-form.php">Zarejestruj</a></div>
</nav>

END;

?>