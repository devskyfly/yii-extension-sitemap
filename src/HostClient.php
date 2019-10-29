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

    public function getPageContent($url)
    {
        $url = $this->origin."/".$url;
        $request = $this->client->createRequest()
        ->setMethod('GET')
        ->setUrl($url);

        if (!Vrbl::isEmpty($this->proxy)) {
            $request->setOptions(['proxy' => $this->proxy]);
        }
        
        $response = $request->send();
        $data = $response->content;
        return $data;
    }
}