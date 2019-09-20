<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    public function args(array $args)
    {
        $this->say(implode(', ', $args));
    }

    public function opts($opts = ['mode|m' => false])
    {
        if ($opts['mode']) {
            $this->say('Mode set:'.$opts['mode']);
        } 
        
    }

    public function cmd(array $args, $opts = ['mode|m' => false])
    {
        $this->say(implode(', ', $args));

        if ($opts['mode']) {
            $this->say('Mode set:'.$opts['mode']);
        } 
        
    }

    //TESTS
    function test()
    {

    }

    function runPhpServers()
    {
        $task = $this->taskServer(3000)
        ->dir(__DIR__.'/tests/app')
        //->background()
        ->run();
        //$this->say(print_r($task));
    }

    function runFunctionalTests()
    {
        $task = $this->taskExec(__DIR__.'/vendor/bin/codecept run functional')->run();
        //return new Robo\Result::success($this);
    }

    function runUnitTests()
    {
        $this->taskExec(__DIR__.'/vendor/bin/codecept run unit');
    }

    //SERVICE
    function beforeCommit()
    {
        
    }
}