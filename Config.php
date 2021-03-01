<?php namespace Theatre;

class Config
{

    /*
    * Your web app name. This will be shown in title bar and header.
    */
    public $appName = "My Theatre";

    /*
    * This is application address, you can override the value. Default value is localhost.
    */
    public $address = "localhost";

    /*
    * This is application address, you can override the value but make sure your custom port
    * is not overriding any port used by system nor third application. Default value is 2121
    */
    public $port = "2121";

    /*
    * This is the path of your application installation.
    * e.g. your installation directory is C:\xampp\htdocs\videos
    * you can fill it to "videos". Default value is blank.
    * (Currently not used by the app, it's just right there in case we need it back)
    */
    public $path = "";

    /*
    * This is 'symlink name' inside the installation directory, which pointing your movies
    * folder anywhere on your disk. Default value is 'movies'
    */
    public $symlink = "movies";

}
