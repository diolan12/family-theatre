<?php

/*
* Your web app name. This will shown in title bar and header.
*/
$appName = "My Theatre";

/*
* This is the path of your application installation.
* e.g. your installation directory is C:\xampp\htdocs\videos
* you can fill it to "videos"
*/
$path = "/videos";

/*
* This is 'symlink name' inside the installation directory, which pointing your movies folder anywhere on your disk.
*/
$symlink = "movies";

/*
* You can edit this if you know what are you doing.
*/
$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . $path;