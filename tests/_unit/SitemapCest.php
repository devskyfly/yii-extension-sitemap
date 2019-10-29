<?php

use Codeception\Stub;
use devskyfly\yiiExtensionSitemap\Container;

class SitemapCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function testSitemap(UnitTester $I)
    {
        $container = Stub::makeEmpty(Container::class, 
            [
            "getAllPages" => require(codecept_data_dir()."/unit/mocks/container/getAllPages.php")
            ]
        );

        $sitemap = Yii::createObject([
            'class'=>'devskyfly\yiiExtensionSitemap\Sitemap',
            'container' => $container
        ]);

        $sitemap->generate();
    }
}
