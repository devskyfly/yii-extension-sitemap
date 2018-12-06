<?php
namespace devskyfly\yiiExtension\sitemap;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Lgc;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use Codeception\PHPUnit\Constraint\Page;



class PageAssets extends ContainerItem
{
    
    public $searchable=true;
    public $class="";
    public $query_params=[];
    public $initCallback=null;
    public $contentCallback=null;

    
    public function init()
    {
        if(!Str::isString($this->route)){
            throw new \InvalidArgumentException('Property $route is not string type.');
        }
        
        if(!Arr::isArray($this->params)){
            throw new \InvalidArgumentException('Property $params is not array type.');
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
        
        if(!Vrbl::isCallable($this->contentCallback)){
            throw new \InvalidArgumentException('Property $contentCallback is not callable type.');
        }
        
        if(!Vrbl::isCallable($this->initCallback)){
            throw new \InvalidArgumentException('Property $initCallback is not callable type.');
        }
    }
    
    /**
     * 
     * @return Generator
     */
    public function getPages()
    {
        $initCallback=$this->initCallback;
        $cls=$this->class;
        $query=$cls::find()->where($this->query_params);
        foreach ($query->each(10) as $item)
        {
               $config=$initCallback();
               $config['contentCallback']=$this->contentCallback;
               $page=new Page($config);
               yield $page;
        }
    }
    
    
}