<?php

use devskyfly\php56\types\Obj;
use devskyfly\yiiExtensionSitemap\Container;
use devskyfly\yiiExtensionSitemap\HostClient;
use devskyfly\yiiExtensionSitemap\Sitemap;
use app\fixtures\ArticleFixture;
use app\fixtures\NewsFixture;

class ExtensionCest
{
    public function _before(FunctionalTester $I)
    {

    }

    public function _fixtures()
    {
        return [
            'articles' => ArticleFixture::className(),
            'news' => NewsFixture::className(),
        ];
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
        $mocks = require codecept_data_dir().'common/container/getStaticPages.php';
        $generator = $container->getAllPages();
        
        $pages_itr = 0;
        $pages_assets_itr = 0;
        $articles = $I->grabFixture('articles');
        $news = $I->grabFixture('news');
        
        $mocksItr = 0;
        $articlesItr = 0;
        $newsItr = 0;
        foreach ($generator as $item) {
            codecept_debug("-***-".$item->title);
            if ($pages_itr < 2) {
                
                $mock = $mocks[$pages_itr];
                $I->assertEquals($item->content, $mock['content']);
                $I->assertEquals($item->title, $mock['title']);
                $I->assertEquals($item->description, $mock['description']);
                $I->assertEquals($item->keywords, $mock['keywords']);
                $mocksItr++;
            } elseif ($pages_itr < 5) {
                
                $I->assertEquals("bt ".$articles[$articlesItr]['name']." at", $item->title);
                $I->assertEquals($articles[$articlesItr]['content'], $item->content);
                $I->assertEquals("bk ".$articles[$articlesItr]['keywords']." ak", $item->keywords);
                $I->assertEquals("bd ".$articles[$articlesItr]['description']." ad", $item->description);
                $articlesItr++;
            } elseif ($pages_itr < 7) {
                $I->assertEquals("bt ".$news[$newsItr]['name']." at", $item->title);
                $I->assertEquals($news[$newsItr]['content'], $item->content);
                $I->assertEquals("bk ".$news[$newsItr]['keywords']." ak", $item->keywords);
                $I->assertEquals("bd ".$news[$newsItr]['description']." ad", $item->description);
                $newsItr++;
            }
            $pages_itr++;
        }
    }

    /** 
     @depends checkContainer
     
    public function sitemapGenerate(FunctionalTester $I)
    {
        $sitemap = Yii::$app->sitemap;
        $sitemap->generate();
    }*/
}
