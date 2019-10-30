<?php
namespace devskyfly\yiiExtensionSitemap;

use yii\base\BaseObject;
use devskyfly\php56\types\Lgc;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use PHPHtmlParser\Dom;

class Page extends BaseObject
{
    public $searchable = true;
    public $data_time = "";
    
    public $title = "";
    public $keywords = "";
    public $description = "";
    
    public $url = "";
    
    public $class = "";
    
    public $content = "";
    public $wrapper_tag = "main";
    
    public $linked_object =null;
    public $callback = null;
    
    public $container = null;
    public $asset = null;

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
        
        if(!Str::isString($this->url)){
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
        
    }

    public function fill()
    {
        $linkedObject = $this->linked_object;
        $callback=$this->callback;
        
        if (Vrbl::isNull($linkedObject)) {
            $page = $this->container->hostClient->getPageContent($this->url);
            $dom = new Dom();
            $dom->loadStr($page, []);
            
            $content = $dom->find($this->wrapper_tag)[0];
            $title = $dom->find("title")[0];
            $keywords = $dom->find("meta[name='keywords']")[0];
            $description = $dom->find("meta[name='description']")[0];
            $this->data_time = (new \DateTime())->format(\DateTime::ATOM);
            
            if ($title) {
                $this->title = $title->text;
            }

            if ($keywords) {
                $this->keywords = $keywords->getAttribute('content');
            }

            if ($description) {
                $this->description = $description->getAttribute('content');
            }
            
            if ($content) {
                $this->content = $content->text;
            }            
        } else {
            $callback($this);
            $this->implemetAsset($this->asset);
        }

        return $this;
    }

    protected function implemetAsset($asset)
    {
        if (Obj::isA($asset, PageAsset::class)) {
           $this->title = $asset->before_title." ".$this->title." ".$asset->after_title;
           $this->keywords = $asset->before_keywords." ".$this->keywords." ".$asset->after_keywords;
           $this->description = $asset->before_description." ".$this->description." ".$asset->after_description;
        }
        return $this;
    }
}