<?php
//$params = require __DIR__ . '/params.php';
//$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */

use yii\web\Controller;

return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset'
    ],
    'language' => 'en-US',
    'components' => [
        'urlManager' => [
            'showScriptName' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
    ],
];