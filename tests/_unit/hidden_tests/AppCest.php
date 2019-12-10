<?php

use app\controllers\SiteController;
use yii\helpers\Url;
//use yii\web\Controller;

class AppCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    {
        $app = Yii::$app;
        
        codecept_debug("@app: ".Yii::getAlias("@app"));
        codecept_debug("controllerNamespace: ".$app->controllerNamespace);
        codecept_debug("controllerPath: ".$app->controllerPath);
        codecept_debug("defaultRoute: ".$app->defaultRoute);

        $modules = [];

        foreach ($app->loadedModules as $key => $module) {
            $modules[] = $key;
        }

        codecept_debug("modules: ".print_r($modules, true));

        $url = Url::toRoute(['site/index']);
        
    }
}
