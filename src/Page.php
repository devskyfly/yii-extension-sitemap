<?php
namespace devskyfly\yiiExtension\sitemap;

use PHPHtmlParser\Dom;
use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Lgc;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use Yii;
use yii\base\BaseObject;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;
use yii\httpclient\Request;


class Page extends ContainerItem
{
    public $data_time;
    
    public $title;
    public $keywords;
    public $description;
    
    public $route;
    public $params=[];
    
    public $wrapper_tag="main";
    
    public $searchable=true;
    public $class="";
    public $query_params=[];
    public $callback=null;
    
    public function init()
    {
        if(!Str::isString($this->title)){
            throw new \InvalidArgumentException('Property $title  is not string type.');
        }
        
        if(!Str::isString($this->keywords)){
            throw new \InvalidArgumentException('Property $keywords is not string type.');
        }
        
        if(!Str::isString($this->description)){
            throw new \InvalidArgumentException('Property $description is not string type.');
        }
        
        if(!Str::isString($this->route)){
            throw new \InvalidArgumentException('Property $route is not string type.');
        }
        
        if(!Arr::isArray($this->params)){
            throw new \InvalidArgumentException('Property $params is not array type.');
        }
        
        if(!Str::isString($this->wrapper_tag)){
            throw new \InvalidArgumentException('Property $wrapper_tag is not string type.');
        }
        
        if(!Lgc::isBoolean($this->searchable)){
            throw new \InvalidArgumentException('Property $searchable is not boolean type.');
        }
        
        if(!Str::isString($this->class)){
            throw new \InvalidArgumentException('Property $class is not string type.');
        }
        
        if(!Arr::isArray($this->query_params)){
            throw new \InvalidArgumentException('Property $query_params is not array type.');
        }
    }
    
    public function getContent(Request $request=null)
    {
        if(!Vrbl::isCallable($this->callback)){
            $oldControllerNamespace=Yii::$app->controllerNamespace;
            Yii::$app->controllerNamespace='@frontend/controllers';
            $route=ArrayHelper::merge($this->route, $this->params);
            $url=Url::toRoute($route);
            $request->setMethod('GET')
            ->setFormat(Client::FORMAT_RAW_URLENCODED)
            ->setUrl(Url::toRoute($route));
            $response=$request->send();
            
            $data=$response->content;
            $dom= new Dom();
            $data=$dom->loadStr($data,[])->find($this->wrapper_tag)[0];
            Yii::$app->controllerNamespace=$oldControllerNamespace;
            return $data->__toString();
        }else{
            $callback=$this->contentCallback;
            return $callback($this);
        }
        
    }
    
    
}