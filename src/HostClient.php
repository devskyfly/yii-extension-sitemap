<?php
namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\types\Vrbl;
use Yii;
use yii\base\BaseObject;
use yii\helpers\Url;
use yii\httpclient\Client;
use PHPHtmlParser\Dom;

class HostClient extends BaseObject
{
    public $origin = "";
    public $proxy = "";
    public $client = null;

    public function init()
    {
        $this->client = new Client();
    }

    public function getText($route, $wrapTag="main")
    {
        $oldControllerNamespace=Yii::$app->controllerNamespace;
        Yii::$app->controllerNamespace='@frontend/controllers';
        $url=$this->origin.Url::toRoute($route);
        Yii::$app->controllerNamespace=$oldControllerNamespace;
        $request = $this->client->createRequest()
        ->setMethod('GET')
        ->setUrl($url);

        if (!Vrbl::isEmpty($this->proxy)) {
            $request->setOptions(['proxy' => $this->proxy]);
        }
        
        $response = $request->send();
        $data=$response->content;
        $dom= new Dom();
        $data=$dom->loadStr($data, [])->find($wrapTag)[0];
        return $data->__toString();
    }
}