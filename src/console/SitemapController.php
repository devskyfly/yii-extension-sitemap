<?php

namespace devskyfly\yiiExtensionSitemap\console;

use Yii;
use yii\console\Controller;
use yii\helpers\BaseConsole;

class SitemapController extends Controller
{
    public function actionIndex()
    {
        BaseConsole::output("Hello".PHP_EOL);
    }

    public function actionGenerate()
    {
        $sitemap = Yii::$app->sitemap;
        $sitemap->generate();
    }
}