<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    function test()
    {
        $this->taskServer(3000)
        ->dir(__DIR__.'/tests/app')
        ->run();
    }
}