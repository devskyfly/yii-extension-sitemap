<?php

use devskyfly\php56\types\Obj;
use devskyfly\yiiExtensionSitemap\Sitemap;

class SitemapCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function testSitemap(FunctionalTester $I)
    {
        $sitemap = Yii::$app->sitemap;
        $I->assertTrue(Obj::isA($sitemap, Sitemap::class));
    }
}
