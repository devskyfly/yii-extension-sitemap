<?php
namespace devskyfly\yiiExtensionSitemap;

use Yii;
use yii\base\BaseObject;
use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Lgc;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;

class Page extends BaseObject
{
    public $searchable = true;
    public $data_time = "";
    
    public $title = "";
    public $keywords = "";
    public $description = "";
    
    public $route = "";
    public $route_params=[];
    
    public $class = "";
    
    public $content = "";
    public $wrapper_tag = "main";
    
    public $linked_object =null;
    public $callback = null;
    

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
        
        if(!Str::isString($this->wrapper_tag)){
            throw new \InvalidArgumentException('Property $wrapper_tag is not string type.');
        }
        
        if(!Lgc::isBoolean($this->searchable)){
            throw new \InvalidArgumentException('Property $searchable is not boolean type.');
        }
        
        if(!Str::isString($this->class)){
            throw new \InvalidArgumentException('Property $class is not string type.');
        }
        
        if(!Arr::isArray($this->route_params)){
            throw new \InvalidArgumentException('Property $route_params is not array type.');
        }
    }

    public function fill()
    {
        $linkedObject = $this->linked_object;
        $callback=$this->callback;
        
        if (Vrbl::isNull($linkedObject)) {
            $page = $this->client->getText([$this->route, $this->route_params], $this->wrapper_tag);

            $dom = new Dom();
            $dom->loadStr($page, []);

            $content = $dom->find($this->wrapper_tag);
            $content = ArrayHelper::getValue($content, 0, null);

            $title = $dom->find("title");
            $title = ArrayHelper::getValue($title, 0, null);

            $keywords = $dom->find("meta[name='keywords']");
            $keywords = ArrayHelper::getValue($keywords, 0, null);

            $description = $dom->find("meta[name='description']");
            $description = ArrayHelper::getValue($description, 0, null);

            $this->data_time = (new \DateTime())->format(\DateTime::ATOM);
            
            if ($title) {
                $this->title = $title->text;
            }

            if ($keywords) {
                $this->keywords = $description->getAttribute('keywords');
            }

            if ($description) {
                $this->description = $description->getAttribute('content');
            }

            if ($content) {
                $this->content = $content->text;
            }            
        } else {
            return $callback($this->linked_object);
        }

        return $this;
    }
}