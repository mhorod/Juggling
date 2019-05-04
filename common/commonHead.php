<?php

//Normalize path
$dir = str_replace('\\', '/', __DIR__);
$root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$path = str_replace($root, '', $dir);

session_start();
echo<<<END
<meta charset = "utf-8"/>
<link rel = "icon" href = "$path/favicon.ico"/>

<link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<link rel = "stylesheet" href = "$path/stylesheets/design/design.css" type = "text/css"/>
<link rel = "stylesheet" href = "$path/stylesheets/design/canvas-style.css" type = "text/css"/>


<link rel="stylesheet" media="screen and (min-width: 600px)" href="$path/stylesheets/appearance/medium-screen-style.css">
<link rel="stylesheet" media="screen and (min-width: 1000px)" href="$path/stylesheets/appearance/wide-screen-style.css">
<link rel="stylesheet" media="screen and (max-width: 600px)" href="$path/stylesheets/appearance/small-screen-style.css">
<link rel="stylesheet" href="$path/stylesheets/appearance/common-screen-style.css">

<script src = "$path/../scripts/juggler.js"></script>
END;
?>