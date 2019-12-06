<?php
namespace app\controllers;

use app\models\News;
use yii\web\Controller;

class NewsController extends Controller
{
    public function actionIndex()
    {
        $list = [];
        $news = News::find()->where([])->all();
        
        foreach ($news as $new) {
            $list[] = ['name' => $new->name, 'link' => Url::toRoute(['detail', 'name' => $new->name])];
        }

        return $this->render('index', compact("list"));
    }

    public function actionDetail($name = null)
    {
        $this->view->title = "News detail page";
        
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'News description'
        ]);

        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'News keywords'
        ]);

        $model = News::find()->where(["name" => $name])->one();

        if (Vrbl::isNull($model)) {
            throw new NotFoundException();
        }

        return $this->render("detail", ["model" => $model]);
    }
}