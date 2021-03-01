<?php

/*
* Your web app name. This will shown in title bar and header.
*/
$appName = "My Theatre";

/*
* This is the path of your application installation.
*/
$path = "videos";

/*
* This is symlink which will be used to pointing your movies folder anywhere on your disk.
*/
$symlink = "movies";

/*
* You can edit this if you know what are you doing.
*/
$baseUrl = "http://" . $_SERVER['SERVER_NAME'] ."/". $path;