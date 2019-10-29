<?php
namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use Yii;
use yii\base\BaseObject;

class Container extends BaseObject
{
    /**
     * 
     * @var callable
     */
    public $initCallback=null;
    
    /**
     *
     * @var HostClient
     */
    public $hostClient=null;

    /**
     *
     * @var Page[]
     */
    protected $pagesList=[];
    
    /**
     *
     * @var PageAsset[]
     */
    protected $pagesAssetList=[];
    
    public function init()
    {
        parent::init();

        if (!Vrbl::isCallable($this->initCallback)) {
            throw new SitemapException('Property initCallback is not callable type.'); 
        }

        if (!Obj::isA($this->hostClient, HostClient::class)) {
            $this->hostClient = Yii::createObject($this->hostClient);
        }
    }
    
    protected function initLists($callback=null)
    {
        if(Vrbl::isNull($callback)){
            $callback=$this->initCallback;
        }
        if(!Vrbl::isCallable($callback)){
            throw new SitemapException('Param callback is not callable type.');
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
        $item->container = $this;
        $this->pagesList[$item->url]=$item;
        return $this;
    }
    
    /**
     *
     * @param PageAsset $item
     */
    public function insertPageAsset(PageAsset $item)
    {
        $this->pagesAssetList[$item->url]=$item;
        return $this;
    }
    
    /**
     * 
     * @param string $key
     * @throws \OutOfBoundsException
     */
    public function removePage($key)
    {
        if(!Arr::keyExists($this->pagesList, $key)){
            throw new \OutOfBoundsException("Key '{$key}' does not exist");
        }
        
        unset($this->pagesList[$key]);
        return $this;
    }
    
    /**
     *
     * @param string $key
     * @throws \OutOfBoundsException
     */
    public function removePageAsset($key)
    {
        if(!Arr::keyExists($this->pagesAssetList, $key)){
            throw new \OutOfBoundsException("Key '{$key}' does not exist");
        }
        
        unset($this->pagesAssetList[$key]);
        return $this;
    }
    
    
    /**
     *
     * @return Generator
     */
    public function getPagesList()
    {
        $list=$this->pagesList;
        
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
        $list=$this->pagesAssetList;
        
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
        $this->initLists();
        $generator=$this->getPagesList();
        
        foreach ($generator as $page){
            yield $page;
        }
        
        $pagesAssetList=$this->getPagesAssetList();
        foreach ($pagesAssetList as $asset){
            $generator=$asset->getPagesList();
            foreach ($generator as $page){
                yield $page;
            }
        }
    }
}
