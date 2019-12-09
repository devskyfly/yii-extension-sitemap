<?php
namespace devskyfly\yiiExtensionSitemap;

use yii\base\BaseObject;
use devskyfly\php56\types\Lgc;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use PHPHtmlParser\Dom;

class Page extends BaseObject
{
    public $searchable = true;
    public $date_time = "";
    
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

    public $priority = 0.5;

    public function init()
    {
        parent::init();

        if (!Str::isString($this->title)) {
            throw new \InvalidArgumentException('Property $title  is not string type.');
        }
        
        if (!Str::isString($this->keywords)) {
            throw new \InvalidArgumentException('Property $keywords is not string type.');
        }
        
        if (!Str::isString($this->description)) {
            throw new \InvalidArgumentException('Property $description is not string type.');
        }
        
        if (!Str::isString($this->url)) {
            throw new \InvalidArgumentException('Property $route is not string type.');
        }
        
        if (!Vrbl::isNull($this->asset)) {
            $params = [];

            foreach ($this->asset->route_params as $param_name) {
                $params[] = urlencode($this->linked_object[$param_name]);
            }
            $url = vsprintf($this->asset->route, $params);
            
            $this->url = $url;
        }

        if (!Str::isString($this->wrapper_tag)) {
            throw new \InvalidArgumentException('Property $wrapper_tag is not string type.');
        }
        
        if (!Lgc::isBoolean($this->searchable)) {
            throw new \InvalidArgumentException('Property $searchable is not boolean type.');
        }
        
        if (!Str::isString($this->class)) {
            throw new \InvalidArgumentException('Property $class is not string type.');
        }
        
        if (!Nmbr::isNumeric($this->priority)) {
            throw new \InvalidArgumentException('Property $priority is not number type.');
        }
    }

    public function fill()
    {
        
        $callback = $this->callback;
        
        if (!Vrbl::isNull($this->asset)
            && !empty($this->wrapper_tag)) {
            $this->fillByClient();

        } elseif (!Vrbl::isNull($this->asset)
            && empty($this->wrapper_tag)) {
            $callback($this);
            
        } else {
            $this->fillByClient();
        }

        $this->implementAssetSeoData($this->asset);
        return $this;
    }

    protected function fillByClient()
    {
        $url = "";
        $page = $this->container->hostClient->getPageContent($this->url, $url);
        $dom = new Dom();
        $dom->loadStr($page, []);
        
        $content = $dom->find($this->wrapper_tag)[0];
        
        $title = $dom->find("title")[0];
        $keywords = $dom->find("meta[name='keywords']")[0];
        $description = $dom->find("meta[name='description']")[0];
        $this->date_time = (new \DateTime())->format(\DateTime::ATOM);
        
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

        if ($url) {
            $this->url = $url;
        }
    }

    protected function implementAssetSeoData($asset)
    {
        if (Obj::isA($asset, PageAsset::class)) {
           $this->title = $asset->before_title." ".$this->title." ".$asset->after_title;
           $this->keywords = $asset->before_keywords." ".$this->keywords." ".$asset->after_keywords;
           $this->description = $asset->before_description." ".$this->description." ".$asset->after_description;
           $origin = $this->container->hostClient->origin;
           $this->url = $origin."/".$this->url;
        }
        return $this;
    }
}