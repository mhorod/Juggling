<?php
$dir = str_replace('\\', '/', __DIR__);
$root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$path = str_replace($root, '', $dir);
session_start();

echo<<<END
<meta charset = "utf-8"/>
<link rel = "icon" href = "$path/favicon.ico"/>
<link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">

<link rel = "stylesheet" href = "$path/stylesheets/design.css" type = "text/css"/>
<link rel = "stylesheet" href = "$path/stylesheets/canvas-style.css" type = "text/css"/>


<link rel="stylesheet" media="screen and (min-width: 600px)" href="$path/stylesheets/medium-screen-style.css">
<link rel="stylesheet" media="screen and (min-width: 1000px)" href="$path/stylesheets/wide-screen-style.css">
<link rel="stylesheet" media="screen and (max-width: 600px)" href="$path/stylesheets/small-screen-style.css">
<link rel="stylesheet" href="$path/stylesheets/common-screen-style.css">

<script src = "$path/../scripts/juggler.js"></script>
END;
?>