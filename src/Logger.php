<?php
namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use yii\base\BaseObject;

class Logger extends BaseObject
{
    public $list = [];

    /**
     * Add item to container
     *
     * @param string $url
     * @param string|Exception $msg
     * @return void
     */
    public function addItem($url = "", $msg = "")
    {
        if (!Vrbl::isString($url)) {
            throw SitemapException('Parameter $url is not string type.');
        }

        if (!Vrbl::isString($url)||!Obj::isA($msg, \Exception::class)) {
            throw SitemapException('Parameter $msg is not string or '.\Exception::class.' type.');
        }

        if (Obj::isA($msg, \Exception::class)) {
            $msg = $msg->getMessage();
        }

        $this->list[] = ['url' => $url, 'msg' => $msg];
    }

    public function getList()
    {
        foreach ($this->list as $item) {
            yield $item;
        }
    }
}