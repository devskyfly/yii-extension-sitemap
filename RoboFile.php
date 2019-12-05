<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    //TESTS
    /**
     * Run all test suites or one, optional it runs local server.
     * 
     * --suite|s = ["all", "unit", "functional"]
     * --localserver|l = false
     * --debug|d = false
     */
    public function testsRun($opts = ["suite|s" => "all", "debug|d" => false,"localserver|l" => false])
    {
        $this->testsClear();
        
        $suites = [
            "all",
            "unit",
            "functional"
        ];

        if (!in_array($opts["suite"], $suites)) {
            throw new \InvalidArgumentException('Option suite is out of list:'.implode($suites));
        }

        if ($opts['localserver']) {
            $this->testsSeverRun(["port" => 3000, "back" => true]);
        }

        $collection = $this->collectionBuilder();

        if ($opts['suite'] == "all" || $opts['suite'] == "unit") {
            $collection->addTask($this->taskExec(__DIR__.'/vendor/bin/codecept run unit'.($opts['debug']?" --debug":"")));
        }

        if ($opts['suite'] == "all" || $opts['suite'] == "functional") {
            $collection->addTask($this->taskExec(__DIR__.'/vendor/bin/codecept run functional'.($opts['debug']?" --debug":"")));
        }
        
        $collection->run();
    }

    public function testsClear()
    {
        $files = glob($this->testsAppWebPath()."/tmpl/*.xml");
        $this->taskFilesystemStack()
        ->remove($files)
        ->run();
    }

    protected function testsPath()
    {
        $path = getcwd()."/tests";
        if (!file_exists($path)) {
            throw new \RuntimeException("Dir {$path} does not exist.");
        }
        return $path;
    }

    protected function testsAppWebPath()
    {
        $path = $this->testsPath()."/app/web";
        if (!file_exists($path)) {
            throw new \RuntimeException("Dir {$path} does not exist.");
        }
        return $path;
    }

    /**
     * Run local server in .
     *
     * --port integer
     */
    public function testsSeverRun($opts = ["port|p" => "3000", "back|b" => false])
    {
        $dir = $this->testsAppWebPath();
        $server = $this->taskServer($opts["port"]);
        if ($opts["back"]) {
            $server->background();
        }
        $server->dir($dir)
        ->run();
    }

    
}