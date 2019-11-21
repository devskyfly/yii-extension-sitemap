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

    public function testsFunctional($port = 3000)
    {
        $collection = $this->collectionBuilder();
        $collection
        ->addTask($this->taskServer($port)
            ->background()
            ->dir(__DIR__.'/tests/appFunc/web/')
        );
        /*if ($port) {
            $server = $this->taskServer($port)
            ->dir(__DIR__.'/tests/appFunc/web/')
            //->background()
            ->run();
        }*/
        $collection->addTask($this->taskExec(__DIR__.'/vendor/bin/codecept run functional'));
        $collection->run();

        //if ($server->wasSuccessful()) {
            //$task = $this->taskExec(__DIR__.'/vendor/bin/codecept run functional')->run();
            //$server->stop();
        //}
    }

    public function testsAcceptence()
    {
        $task = $this->taskExec(__DIR__.'/vendor/bin/codecept run unit')->run();
    }

    /*public function serverRun($dir = 'tests/appFunc/web', $port = 3000)
    {
        return $this->taskServer($port)->dir($dir)->background()->run();
    }*/

    protected $steps = 10;

    public function progressIndicatorSteps()
    {
        return $this->steps;
    }

    public function run()
    {
        $exitCode = 0;
        $errorMessage = "";

        $this->startProgressIndicator();
        for ($i = 0; $i < $this->steps; ++$i) {
            $this->advanceProgressIndicator();
        }
        $this->stopProgressIndicator();

        return new Result($this, $exitCode, $errorMessage, ['time' => $this->getExecutionTime()]);
    }
}