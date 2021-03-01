<?php

namespace Theatre\Bin;

require_once '././Config.php';

use Theatre\Config;

class Bin
{
    protected $config;
    public $version = "1.0.178";
    function __construct()
    {
        $this->config = new Config();
    }
    public function parseArgs(array $rawArgs)
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
    public function execute(string $command)
    {
        $output = null;
        $retval = null;
        exec($command, $output, $retval);
        $result = [
            "retval" => $retval,
            "output" => $output
        ];
        echo "\n";
        return $result;
    }
    public function serve(array $args)
    {
        $address = $this->config->address;
        if (isset($args['addr'])) $address = $args['addr'];
        $port = $this->config->port;
        if (isset($args['port'])) $port = $args['port'];

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
    public function unlink(array $args)
    {
        $symlink = strval($this->config->symlink);
        if (is_dir($symlink)) {
            $shell = "rmdir $symlink";
            $this->execute($shell);
            echo "\033[01;32m Symlink deleted \033[0m \n";
        } else {
            echo "\033[01;31m Symlink not exist \033[0m \n";
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
                $this->execute($shell);
                echo "\033[01;32m Symlink created \033[0m \n";
            } else {
                echo "\033[01;31m Missing arguments for symlink \033[0m \n";
            }
        }
    }
    public function index(array $args)
    {
        if(isset($args['folder']) && isset($args['type'])){
            $this->addIndex($args);
        }
        $movies = [];
        if (is_dir($this->config->symlink)) {
            if ($handle = opendir($this->config->symlink)) {
                $blacklist = array('.', '..', 'somedir', 'somefile.php');
                while (false !== ($folder = readdir($handle))) {
                    if (!in_array($folder, $blacklist)) {
                        $index = count($movies);
                        $movies[$index]['folder'] = $folder;
                        if(file_exists($this->config->symlink . "/" . $folder . "/index.json")){
                            $json = file_get_contents($this->config->symlink . "/" . $folder . "/index.json");
                            $movies[$index]['info'] = json_decode($json, true);
                        }
                        if (file_exists($this->config->symlink . "/" . $folder . "/poster.jpg")) {
                            $movies[$index]['poster'] = $this->config->symlink . "/" . $folder . "/poster.jpg";
                        }
                    }
                }
                closedir($handle);
                foreach ($movies as $movie) {
                    $indexed = array_key_exists('info', $movie) ? "\033[01;32mindexed\033[0m" : "\033[01;31mnot indexed\033[0m";
                    $poster = file_exists($this->config->symlink . "/" . $movie['folder'] . "/poster.jpg") ? "\033[01;32mwith poster\033[0m" : "\033[01;31mposter not exist\033[0m";
                    echo "[".$movie['folder']."] ($indexed)($poster)\n";
                }
            }
        } else {
            echo "\033[01;31m Symlink not connected \033[0m \n";
        }
    }
    protected function addIndex(array $args){
        if($args['type'] != 'movie' && $args['type'] != 'serial'){
            echo "\033[01;31m ".$args['type']." is not correct known video type.\033[0m\n\n";
            return false;
        }

        $json = getcwd()."\\".$args['type']."_index.json";
        // $isExist = file_exists($json) ? "\033[01;32mexist\033[0m" : "\033[01;31mnot exist\033[0m";
        if(!file_exists($json)) {
            echo "\033[01;31m ".$args['type']."_index.json is not exist, please reinstall this application!\033[0m\n\n";
            return false;
        }

        $folder = getcwd()."\\".$this->config->symlink."\\".$args['folder'];
        if(!is_dir($folder)) {
            echo "\033[01;31m Directory [".$args['folder']."] does not exist\033[0m\n\n";
            return false;
        }

        $index = $folder."\\index.json";
        if(file_exists($index)) {
            echo "\033[01;31m Directory [".$args['folder']."] already indexed\033[0m\n\n";
            return false;
        }
        // $isDir = is_dir($json) ? "\033[01;32mexist\033[0m" : "\033[01;31mnot exist\033[0m";
        // echo "$json $isExist\n";
        // echo "$folder $isDir\n";
        
        
        if(copy($json, $folder."\\index.json")) echo "\033[01;32m[".$args['folder']."] successfully indexed\033[0m\n\n";
        else echo "\033[01;31m[".$args['folder']."] failed to indexed\033[0m\n\n";
    }
    public function status(array $args)
    {
        $this->version($args);

        echo "\033[01;33m Current application status: \033[0m \n";
        $address = $this->config->address;
        echo "address \t\t: $address\n";
        $port = $this->config->port;
        echo "port \t\t\t: $port\n";
        $symlink = $this->config->symlink;
        echo "symlink \t\t: $symlink\n";
        $connected = is_dir($this->config->symlink) ? 'true' : 'false';
        echo "connected \t\t: $connected\n";
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
        echo "- status\t\t: Display application current status.\n";
        echo "- serve {args}\t\t: Serving the application.\n";
        echo "- index \t\t: Showing list of indexed directories.\n";
        echo "- index {args}\t\t: Indexing a given directory name in argument, then showing list of indexed directories.\n\n";

        echo "\033[01;33m List of available arguments: \033[0m \n";
        echo "- symlink={path}\t: Use with link command to link the application with video directory.\n";
        echo "\t\t\t  e.g. (php app link symlink=D:\\Videos)\n";
        echo "- folder={dir name}\t: Use with index command to index a video directory.\n";
        echo "- type={video type}\t: Use with index command to index a video directory type.\n";
        echo "\t\t\t  e.g. (php app index folder=\"The Mandalorian - Season 2\" type=serial)\n";
        echo "- addr={address}\t: Use with serve command to specify the server address (default: localhost).\n";
        echo "\t\t\t  e.g. (php app serve addr=192.168.1.2)\n";
        echo "- port={port}\t\t: Use with serve command to specify the server port (default: 2121).\n";
        echo "\t\t\t  e.g. (php app serve port=8080)\n\n";

        echo "\033[01;33m Additional tips: \033[0m \n";
        echo "\tTo serve this application just run this command \033[00;32mphp app serve addr={your.ip} port={your_port}\033[0m.\n";
        echo "Make sure you already link the video directory first, otherwise it will return error.\n";
        echo "Replace the 'your.ip' with your machine IP address and 'your_port' with your desired unused port,\n";
        echo "You can use port 80 when apache/nginx is not running.\n";
        echo "You can not access this application from other devices when your default address\n";
        echo "is localhost, use your machine IP address instead of localhost.\n\n";
        echo "\033[00;34m Enjoy the movie :) \033[0m\n";
    }
}
