<?php namespace Theatre;

require_once 'Config.php';
require_once 'bin\Bin.php';

use Theatre\Config;
use Theatre\Bin\Bin;
class App
{
    protected $config;
    protected $bin;
    
    public function runCommand(array $args)
    {
        $this->config = new Config();
        $this->bin = new Bin();

        if (isset($args[1])) {

            $command = strval($args[1]);
            $args = $this->bin->parseArgs($args);
            // foreach ($args as $arg){
            //     echo "$arg\n";
            // }

            echo "\n";
            $this->bin->$command($args);
            echo "\n\n";
        } else {
            $args = $this->bin->parseArgs($args);

            echo "\n";
            $this->bin->help($args);
            echo "\n\n";

            exit;
        }
    }
}

if (php_sapi_name() !== 'cli') {
    exit;
}

$app = new App();
$app->runCommand($argv);
