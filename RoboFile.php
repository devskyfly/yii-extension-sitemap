<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    function runPhpServers()
    {
        $task = $this->taskServer(3000)
        ->dir(__DIR__.'/tests/appFunc/web')
        //->background()
        ->run();
    }

    function runFunctionalTests()
    {
        $task = $this->taskExec(__DIR__.'/vendor/bin/codecept run functional')->run();
    }

}