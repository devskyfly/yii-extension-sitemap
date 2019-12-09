<?php
namespace app\controllers;

use app\models\News;
use devskyfly\php56\types\Vrbl;
use yii\helpers\Url;
use yii\web\Controller;

class NewsController extends Controller
{
    public function actionIndex()
    {
        $list = [];
        $news = News::find()->where([])->all();
        
        foreach ($news as $new) {
            $list[] = ['name' => $new->name, 'url' => Url::toRoute(['detail', 'name' => $new->name])];
        }

        return $this->render('index', compact("list"));
    }

    public function actionDetail($name = null)
    {
        $this->view->title = "News detail page";
        
        $model = News::find()->where(["name" => $name])->one();

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->name.' description'
        ]);

        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $model->name.' keywords'
        ]);

        if (Vrbl::isNull($model)) {
            throw new NotFoundException();
        }

        return $this->render("detail", ["model" => $model]);
    }
}