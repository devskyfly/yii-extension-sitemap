<?php

use devskyfly\php56\types\Obj;
use devskyfly\yiiExtensionSitemap\Container;
use devskyfly\yiiExtensionSitemap\HostClient;
use devskyfly\yiiExtensionSitemap\Sitemap;
use app\fixtures\ArticleFixture;
use app\models\Article;

use function PHPSTORM_META\type;

class SitemapCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _fixtures()
    {
        return ['articles' => ArticleFixture::className()];
    }

    public function checkSitemapCmp(FunctionalTester $I)
    {
        $sitemap = Yii::$app->sitemap;
        $I->assertTrue(Obj::isA($sitemap, Sitemap::class));
    }

    /**
     @depends checkSitemapCmp
     */
    public function checkSitemapContainer(FunctionalTester $I)
    {
        $sitemap = Yii::$app->sitemap;
        $container = $sitemap->container;
        $I->assertTrue(Obj::isA($container, Container::class));
        
        $hostClient = $container->hostClient;
        $I->assertTrue(Obj::isA($hostClient, HostClient::class));
    }

    /**
     @depends checkSitemapContainer
     */
    
    public function checkContainer(FunctionalTester $I)
    {
        $sitemap = Yii::$app->sitemap;
        $container = $sitemap->container;
        $mocks = require codecept_data_dir().'functional/getStaticPages.php';
        $generator = $container->getAllPages();
        
        $pages_itr = 0;
        $pages_assets_itr = 0;
        $articles = $I->grabFixture('articles');
        
        foreach ($generator as $item) {
            if ($pages_itr < 2) {
                $mock = $mocks[$pages_itr];
                
                $I->assertEquals($item->content, $mock['content']);
                $I->assertEquals($item->title, $mock['title']);
                $I->assertEquals($item->description, $mock['description']);
                $I->assertEquals($item->keywords, $mock['keywords']);
                $pages_itr++;
            } else {
                $I->assertEquals($articles[$pages_assets_itr]['name'], $item->title);
                $I->assertEquals($articles[$pages_assets_itr]['content'], $item->content);
                
                $pages_assets_itr++;
            }
        }
    }
}
