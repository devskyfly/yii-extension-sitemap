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

    /*public function checkSitemapCmp(FunctionalTester $I)
    {
        $sitemap = Yii::$app->sitemap;
        $I->assertTrue(Obj::isA($sitemap, Sitemap::class));
    }

    
    public function checkSitemapContainer(FunctionalTester $I)
    {
        $sitemap = Yii::$app->sitemap;
        $container = $sitemap->container;
        $I->assertTrue(Obj::isA($container, Container::class));
        
        $hostClient = $container->hostClient;
        $I->assertTrue(Obj::isA($hostClient, HostClient::class));
    }*/

    
    public function checkContainer(FunctionalTester $I)
    {
       
        $sitemap = Yii::$app->sitemap;
        $container = $sitemap->container;
        

        $generator = $container->getAllPages();

        $mocks = require codecept_data_dir().'functional/getStaticPages.php';
        
        $i = 0;
        foreach ($generator as $item) {
            $mock = $mocks[$i];
            $item->fill();
            $I->assertEquals($item->content, $mock['content']);
            $I->assertEquals($item->title, $mock['title']);
            $I->assertEquals($item->description, $mock['description']);
            $I->assertEquals($item->keywords, $mock['keywords']);
            $i++;
        }
    }
}
