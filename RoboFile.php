<?php
require __DIR__."/vendor/autoload.php";

use devskyfly\robocmd\DevTestTrait;

class RoboFile extends \Robo\Tasks
{
    use DevTestTrait;    

    public function testsClear()
    {
        
        $wepPath = $this->testsAppWebPath();
        $tmpPath = $wepPath.'/tmpl';

        
        $tmlFiles = glob($tmpPath."/*");
        $this->say(implode(",", $tmlFiles));
        $this->taskFilesystemStack()->remove($tmlFiles)->run();
    }
}