<?php
namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\types\Vrbl;
use yii\base\BaseObject;
use yii\httpclient\Client;

class HostClient extends BaseObject
{
    public $origin = "";
    public $proxy = "";
    public $client = null;

    public function init()
    {
        $this->client = new Client();
    }

    public function getPageContent($url, &$fullUrl)
    {
        if (empty($url)) {
            throw new Sitemap('Parameter $url is empty.');
        }

        $url = $this->origin."/".$url;

        \codecept_debug("-***-".$url);

        $fullUrl = $url;
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