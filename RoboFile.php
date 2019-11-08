<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    public function testsUnit()
    {
        $task = $this->taskExec(__DIR__.'/vendor/bin/codecept run unit')->run();
    }

    public function testsFunctional($opts = ['server|s' => false])
    {
        if ($opts['server']) {
            $this->serverRun();
        }
        $task = $this->taskExec(__DIR__.'/vendor/bin/codecept run functional')->run();
    }

    public function testsAcceptence()
    {
        $task = $this->taskExec(__DIR__.'/vendor/bin/codecept run unit')->run();
    }

    public function serverRun($dir = 'tests/appFunc/web', $port = 3000)
    {
        $this->taskServer($port)->dir($dir)->background()->run();
    }
}