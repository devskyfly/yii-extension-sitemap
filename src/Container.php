<?php
namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use Yii;
use yii\base\BaseObject;
use yii\console\Application;
use yii\helpers\BaseConsole;



class Container extends BaseObject
{
    /**
     *
     * @var Page[]
     */
    protected $pages_list=[];
    
    /**
     *
     * @var PageAsset[]
     */
    protected $pages_asset_list=[];
    
    
    /**
     * 
     * @var callable
     */
    public $init_callback=null;
    
    public function init()
    {
        parent::init();
    }
    
    public function initLists($callback=null)
    {
        if(Vrbl::isNull($callback)){
            $callback=$this->init_callback;
        }
        if(!Vrbl::isCallable($callback)){
            throw new \InvalidArgumentException('Param callback is not callable type.');
        }
        $callback($this);
        return $this;
    }
    
    /**
     * 
     * @param Page $item
     */
    public function insertPage(Page $item)
    {
        //if(Arr::keyExists($this->list, $item->route))
        $this->pages_list[$item->route]=$item;
        return $this;
    }
    
    /**
     *
     * @param PageAsset $item
     */
    public function insertPageAsset(PageAsset $item)
    {
        //if(Arr::keyExists($this->list, $item->route))
        $this->pages_asset_list[$item->route]=$item;
        return $this;
    }
    
    /**
     * 
     * @param string $key
     * @throws \OutOfBoundsException
     */
    public function removePage($key)
    {
        if(!Arr::keyExists($this->pages_list, $key)){
            throw new \OutOfBoundsException("Key '{$key}' does not exist");
        }
        
        unset($this->pages_list[$key]);
        return $this;
    }
    
    /**
     *
     * @param string $key
     * @throws \OutOfBoundsException
     */
    public function removePageAsset($key)
    {
        if(!Arr::keyExists($this->pages_asset_list, $key)){
            throw new \OutOfBoundsException("Key '{$key}' does not exist");
        }
        
        unset($this->pages_asset_list[$key]);
        return $this;
    }
    
    
    /**
     *
     * @return Generator
     */
    public function getPagesList()
    {
        $list=$this->pages_list;
        
        foreach ($list as $item){
            yield $item;
        }
    }
    
    /**
     * 
     * @return Generator
     */
    public function getPagesAssetList()
    {
        $list=$this->pages_asset_list;
        
        foreach ($list as $item){
            yield $item;
        }
    }
    /**
     * 
     * @return Generator
     */
    public function getAllPages()
    {
        $generator=$this->getPagesList();
        
        foreach ($generator as $page){
            yield $page;
        }
        
        $pages_asset_list=$this->getPagesAssetList();
        foreach ($pages_asset_list as $asset){
            $generator=$asset->getPagesList();
            foreach ($generator as $page){
                yield $page;
            }
        }
    }
    
    /**
     * 
     * @param string $route
     * @throws \InvalidArgumentException
     * @return Page|null
     */
    public function getPageByRoute($route)
    {
        if(!Str::isString($route)){
            throw new \InvalidArgumentException('Param $route is not string type.');
        }
        
        if(Arr::keyExists($this->pages_list, $route))
        {
            return $this->pages_list[$route];
        }else{
            return null;
        }
    }
}
