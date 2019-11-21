<?php
namespace app\fixtures;

use app\models\Article;
use yii\test\ActiveFixture;

class ArticleFixture extends ActiveFixture
{
    public $modelClass = Article::class;
}