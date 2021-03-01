<?php

namespace Theatre;

require_once 'Config.php';

use Theatre\Config;

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
$baseUrl = "http://" . isset($_SERVER['HTTP_HOST']) . $path;


class App
{
    protected $config;
    protected $version = "1.0";
    function parseArgs(array $rawArgs)
    {
        $parsedArgs = array();
        unset($rawArgs[0]);
        unset($rawArgs[1]);
        foreach ($rawArgs as $rawArg) {
            $split = explode("=", $rawArg);
            if (isset($split[1])) {
                $parsedArgs[$split[0]] = $split[1];
            }
        }
        return $parsedArgs;
    }
    protected function execute(string $command)
    {
        $output = null;
        $retval = null;
        exec($command, $output, $retval);
        //echo "$retval:\n";
        //print_r($output);
        $result = [
            "retval" => $retval,
            "output" => $output
        ];
        echo "\n";
        return $result;
    }
    public function runCommand(array $args)
    {
        $this->config = new Config();

        if (isset($args[1])) {

            $command = strval($args[1]);
            $args = $this->parseArgs($args);

            echo "\n";
            $this->$command($args);
            echo "\n\n";
        } else {
            $args = $this->parseArgs($args);

            echo "\n";
            $this->help($args);
            echo "\n\n";

            exit;
        }
    }
    public function link(array $args)
    {
        $symlink = strval($this->config->symlink);
        if (is_dir($this->config->symlink)) {
            echo "\033[01;31m Symlink already exist \033[0m \n";
        } else {
            $thisPlace = getcwd();
            if (isset($args['symlink'])) {
                $shell = "mklink /J $thisPlace\\$symlink " . $args['symlink'];
                // echo $shell;
                $this->execute($shell);
                echo "\033[01;32m Symlink created \033[0m \n";
            } else {
                echo "\033[01;31m Missing arguments for symlink \033[0m \n";
            }
        }
    }
    public function unlink(array $args)
    {
        $symlink = strval($this->config->symlink);
        if (is_dir($this->config->symlink)) {
            $shell = "rmdir $symlink";
            $this->execute($shell);
            echo "\033[01;32m Symlink deleted \033[0m \n";
        } else {
            echo "\033[01;31m Symlink not exist \033[0m \n";
        }
    }
    public function version(array $args)
    {
        echo "\033[01;35m Family Theatre version $this->version \033[0m \n";
    }
    public function help(array $args)
    {
        $this->version($args);
        echo "\033[00;32m Usage: php app {command} {arguments} \033[0m \n";
        echo "\033[01;33m List of available commands: \033[0m \n";
        echo "- help\t\t\t: Display this help screen.\n";
        echo "- link {args}\t\t: Link application to video directory.\n";
        echo "- unlink\t\t: Unlink application from video directory.\n";
        echo "- version\t\t: Display application version.\n";
        echo "- serve {args}\t\t: Serving the application.\n\n";

        echo "\033[01;33m List of available arguments: \033[0m \n";
        echo "- symlink={path}\t: Use with link command to link the application with video directory.\n";
        echo "\t\t\t  E.g. (php app link symlink=D:\\Videos)\n";
        echo "- addr={address}\t: Use with serve command to specify the server address (default: localhost).\n";
        echo "\t\t\t  E.g. (php app serve addr=192.168.1.2)\n";
        echo "- port={port}\t\t: Use with serve command to specify the server port (default: 2121).\n";
        echo "\t\t\t  E.g. (php app serve port=8080)\n\n";

        echo "\033[01;33m Additional tips: \033[0m \n";
        echo "\tTo serve this application just run this command \033[00;32mphp app serve addr={your.ip} port={your_port}\033[0m.\n";
        echo "Make sure you already link the video directory first, otherwise it will return error.\n";
        echo "Replace the 'your.ip' with your machine IP address and 'your_port' with your desired unused port,\n";
        echo "You can use port 80 when apache/nginx is not running.\n";
        echo "\033[00;34m Enjoy the movie :) \033[0m\n";
    }
    public function serve(array $args)
    {
        $address = $this->config->address;
        if(isset($args['addr'])) $address = $args['addr'];
        $port = $this->config->port;
        if(isset($args['port'])) $port = $args['port'];

        $baseUrl = "";

        if ($port == 80) {
            $baseUrl = "http://$address/";
            echo "\033[01;32m Serving in $baseUrl \033[0m \n";
        } else if ($port == 443) {
            echo "\033[01;31m Serving in https://$address/ \033[0m \n";
            echo "\033[01;31m We limit the app to not run in https / port 443 (not yet supported) \033[0m \n";
            exit;
        } else {
            $baseUrl = "http://$address:$port/";
            echo "\033[01;32m Serving in $baseUrl \033[0m \n";
        }
        putenv("APP_BASE_URL=$baseUrl");
        $shell = "php -S $address:$port";
        $this->execute($shell);
    }
}

if (php_sapi_name() !== 'cli') {
    exit;
}

// use App;

$app = new App();
$app->runCommand($argv);
