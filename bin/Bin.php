<?php namespace Theatre\Bin;
require_once '././Config.php';
class Bin {
    public $version = "1.0";
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
}