<?php 

use \Yii;

class SitemapCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function testSitemap(UnitTester $I)
    {
        $sitemap = Yii::createObject([
            'class'=>'devskyfly\yiiExtensionSitemap\Sitemap',
            'container'=>[
                'class'=>'devskyfly\yiiExtensionSitemap\Container',
                'hostClient'=>[
                    'class'=>'devskyfly\yiiExtensionSitemap\HostClient',
                    'origin'=>'',
                    'proxy'=>'',
                    'client'=>[
                        'class'=>'yii\httpclient\Client'
                    ],
                ],
                'initCallback'=>function ($container) {

                }
            ]
        ]);
    }
}
