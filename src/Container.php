<?php
namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use Yii;
use yii\base\BaseObject;

class Container extends BaseObject
{
    /**
     * 
     * @var callable
     */
    public $initCallback = null;
    
    /**
     *
     * @var HostClient
     */
    public $hostClient = null;

    /**
     *
     * @var Page[]
     */
    protected $pagesList = [];
    
    /**
     *
     * @var PageAsset[]
     */
    protected $pagesAssetList = [];
    
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
    
    /**
     * Execute summary pagesList and pagesAssetList and invoke Page::fill().
     * 
     * It return Page item of collection.
     * 
     * @return Generator
     */
    public function getAllPages()
    {
        $this->reset();
        $this->initLists();
        $generator = $this->getPagesList();
        
        foreach ($generator as $page) {
            $page->fill();
            yield $page;
        }
        
        $pagesAssetsList = $this->getPagesAssetList();

        foreach ($pagesAssetsList as $asset) {
            $generator = $asset->getPagesList();
            foreach ($generator as $page) {
                
                $page->fill();
                
                yield $page;
            }
        }
    }

    /**
     * Clear pages and pages assets arrays.
     *
     * @return void
     */
    public function reset()
    {
        $this->pagesList = [];
        $this->pagesAssetList = [];
    }
    
    /**
     * 
     * @param Page $item
     */
    public function insertPage(Page $item)
    {
        $item->container = $this;
        $this->pagesList[] = $item;
        return $this;
    }
    
    /**
     *
     * @param PageAsset $item
     */
    public function insertPageAsset(PageAsset $item)
    {
        $item->container = $this;
        $this->pagesAssetList[] = $item;
        return $this;
    }
    
    /**
     * Invoke callback to set pages and pages_asset.
     *
     * @param [callable|null] $callback
     * @return void
     */
    protected function initLists($callback = null)
    {
        if (Vrbl::isNull($callback)) {
            $callback = $this->initCallback;
        }

        if (!Vrbl::isCallable($callback)) {
            throw new SitemapException('Param callback is not callable type.');
        }

        $callback($this);
        
        return $this;
    }

    /**
     *
     * @return Generator
     */
    protected function getPagesList()
    {
        $list = $this->pagesList;
        
        foreach ($list as $item) {
            yield $item;
        }
    }
    
    /**
     * 
     * @return Generator
     */
    protected function getPagesAssetList()
    {
        $list = $this->pagesAssetList;
        
        foreach ($list as $item) {
            yield $item;
        }
    }
}
