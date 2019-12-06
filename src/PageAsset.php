<?php
namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Lgc;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use yii\base\BaseObject;

class PageAsset extends BaseObject
{
    public $hostClient;

    public $searchable = true;
    
    public $before_title = "";
    public $before_keywords = "";
    public $before_description = "";
    
    public $after_title = "";
    public $after_keywords = "";
    public $after_description = "";
    
    public $entity_class = "";
    public $query_params = [];
    
    public $item_callback = null;
    public $wrapper_tag = "";

    public $route = "";
    public $route_params = [];
    public $container = null;

    
    public function init()
    {
        parent::init();

        if (!Str::isString($this->before_title)) {
            throw new \InvalidArgumentException('Property $before_title  is not string type.');
        }
        
        if (!Str::isString($this->before_keywords)) {
            throw new \InvalidArgumentException('Property $before_keywords is not string type.');
        }
        
        if (!Str::isString($this->before_description)) {
            throw new \InvalidArgumentException('Property $before_description is not string type.');
        }
        
        if (!Str::isString($this->after_title)) {
            throw new \InvalidArgumentException('Property $title  is not string type.');
        }
        
        if (!Str::isString($this->after_keywords)) {
            throw new \InvalidArgumentException('Property $keywords is not string type.');
        }
        
        if (!Str::isString($this->after_description)) {
            throw new \InvalidArgumentException('Property $description is not string type.');
        }
        
        if (!Lgc::isBoolean($this->searchable)) {
            throw new \InvalidArgumentException('Property $searchable is not boolean type.');
        }
        
        if (!Str::isString($this->entity_class)) {
            throw new \InvalidArgumentException('Property $entity_class is not string type.');
        }
        
        if (!Arr::isArray($this->query_params)) {
            throw new \InvalidArgumentException('Property $query_params is not array type.');
        }
        
        if (!Str::isString($this->wrapper_tag)) {
            throw new \InvalidArgumentException('Property $wrapper_tag is not string type.');
        }

        if (!Str::isString($this->route)) {
            throw new \InvalidArgumentException('Property $route is not string type.');
        }
    }
    
    /**
     * 
     * @return Generator
     */
    public function getPagesList()
    {
        $cls = $this->entity_class;
        $query = $cls::find()->where($this->query_params);
        $item_callback = $this->item_callback;

        foreach ($query->each(10) as $item) {
           $config['searchable'] = $this->searchable;
           $config['linked_object'] = $item;
           $config['callback'] = $item_callback;
           $config['container'] = $this->container;
           $config['wrapper_tag'] = $this->wrapper_tag;
           $config['asset'] = $this;
           $page = new Page($config);
           
           yield $page;
        }
    }
}