<?php
namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Lgc;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use yii\base\BaseObject;

class PageAsset extends BaseObject;
{
    public $hostClient;

    public $searchable=true;
    
    public $before_title="";
    public $before_keywords="";
    public $before_description="";
    
    public $after_title="";
    public $after_keywords="";
    public $after_description="";
    
    public $class="";
    public $route="";
    public $query_params=[];
    public $init_callback=null;
    public $content_callback=null;
    public $wrapper_tag="main";

    
    public function init()
    {
        if(!Str::isString($this->before_title)){
            throw new \InvalidArgumentException('Property $before_title  is not string type.');
        }
        
        if(!Str::isString($this->before_keywords)){
            throw new \InvalidArgumentException('Property $before_keywords is not string type.');
        }
        
        if(!Str::isString($this->before_description)){
            throw new \InvalidArgumentException('Property $before_description is not string type.');
        }
        
        if(!Str::isString($this->after_title)){
            throw new \InvalidArgumentException('Property $title  is not string type.');
        }
        
        if(!Str::isString($this->after_keywords)){
            throw new \InvalidArgumentException('Property $keywords is not string type.');
        }
        
        if(!Str::isString($this->after_description)){
            throw new \InvalidArgumentException('Property $description is not string type.');
        }
        
        if(!Str::isString($this->route)){
            throw new \InvalidArgumentException('Property $route is not string type.');
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
        
        if(!Vrbl::isCallable($this->content_callback)){
            throw new \InvalidArgumentException('Property $content_callback is not callable type.');
        }
        
        if(!Vrbl::isCallable($this->init_callback)){
            throw new \InvalidArgumentException('Property $init_callback is not callable type.');
        }
        
        if(!Str::isString($this->wrapper_tag)){
            throw new \InvalidArgumentException('Property $wrapper_tag is not string type.');
        }
    }
    
    /**
     * 
     * @return Generator
     */
    public function getPagesList()
    {
        $init_callback=$this->init_callback;
        $cls=$this->class;
        $query=$cls::find()->where($this->query_params);
        foreach ($query->each(10) as $item)
        {
           $content_callback=$this->content_callback;
           $config=$init_callback($item);
           
           $config['title']=$this->before_title.$config['title'].$this->after_title;
           $config['keywords']=$this->before_keywords.$config['keywords'].$this->after_keywords;
           $config['description']=$this->before_description.$config['description'].$this->after_description;
           
           $config['searchable']=$this->searchable;
           $config['linked_object']=$item;
           $config['content_callback']=$content_callback;
           $config['hostClient']=$this->hostClient;
           
           $page=new Page($config);
           yield $page;
        }
    }
}