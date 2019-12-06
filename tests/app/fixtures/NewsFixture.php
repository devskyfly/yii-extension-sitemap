<?php
namespace app\fixtures;

use app\models\News;
use yii\test\ActiveFixture;

class NewsFixture extends ActiveFixture
{
    public $modelClass = News::class;
}