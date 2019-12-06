<?php
namespace app\controllers;

use app\models\News;
use yii\web\Controller;

class NewsController extends Controller
{
    public function actionDetail($name = null)
    {
        /*if (Vrbl::isNull($name)) {
            throw new NotFoundException();
        }*/

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
        return $this->render("detail", ["model" => $model]);
    }
}