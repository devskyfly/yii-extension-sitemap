<?php

namespace devskyfly\yiiExtensionSitemap\console;

use yii\console\Controller;

class SitemapController extends Controller
{
    public function actionGenerate()
    {
        $sitemap = Yii::$sitemap;
        $sitemap->generate();
    }
}