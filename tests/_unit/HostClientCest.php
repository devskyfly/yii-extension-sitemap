<?php

use yii\httpclient\Client;
use Codeception\Util\Stub;
use devskyfly\yiiExtensionSitemap\HostClient;

class HostClientCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    {
        $client = Stub::makeEmpty(Client::class);
        $hostclient = new HostClient(["origin"=>"http://localhost", "client"=>$client]);
        $hostclient->getPageContent('site/index');
    }
}
l