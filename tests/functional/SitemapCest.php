<?php

use devskyfly\php56\types\Obj;
use devskyfly\yiiExtensionSitemap\Container;
use devskyfly\yiiExtensionSitemap\HostClient;
use devskyfly\yiiExtensionSitemap\Sitemap;

class SitemapCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function checkSitemapCmp(FunctionalTester $I)
    {
        $sitemap = Yii::$app->sitemap;
        $I->assertTrue(Obj::isA($sitemap, Sitemap::class));
    }

    /**
     * @depends checkSitemapCmp
     */
    public function checkSitemapContainer(FunctionalTester $I)
    {
        $sitemap = Yii::$app->sitemap;
        
        $container = $sitemap->container;
        $I->assertTrue(Obj::isA($container, Container::class));
        
        $hostClient = $container->hostClient;
        $I->assertTrue(Obj::isA($hostClient, HostClient::class));
    }
}
