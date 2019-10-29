<?php
use yii\web\Application;

require codecept_root_dir().'tests/yiiBootstrap.php';

Yii::setAlias("@app", codecept_root_dir()."tests/appUnit");
Yii::setAlias("@frontend", codecept_root_dir()."tests/appUnit");
Yii::setAlias("@web", codecept_root_dir()."@frontend/web");

$config = require (codecept_root_dir()."tests/appUnit/config/config.php");
(new Application($config))->run();