<?php
namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\libs\fileSystem\Dirs;
use devskyfly\php56\types\Vrbl;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\httpclient\Request;
use yii\httpclient\Client;
use devskyfly\php56\types\Obj;

class Sitemap extends BaseObject
{
    /**
     *
     * @var string
     */
    public $sitemap_path='@frontend/web';
    
    /**
     * 
     * @var Container
     */
    public $container=null;
    
    /**
     *
     * @var callable
     */
    public $container_init_callback=null;
    
    
    public function init()
    {
        parent::init();
        
        if(Vrbl::isNull($this->container)){
            $this->container=new Container();
        }else{
            if(!Obj::isA($this->container, Container::class)){
                throw new \InvalidArgumentException('Property $container is not '.Container::class.' class.');
            }
        }
        
        $this->checkSiteMapPath();
    }
    
    public function initContainer()
    {
        if(!Vrbl::isCallable($this->container_init_callback)){
           throw new \InvalidArgumentException(); 
        }
        $this->container->initLists($this->container_init_callback);
        return $this;
    }

    /**
     * @todo Nead to realize
     */
    public function generateXml()
    {
       /*  
        $generator=$this->container->getPages();
        foreach ($generator as $item){
            
        }
        */
    }
    
    /**
     *
     * @throws yii\base\InvalidArgumentException
     * @return boolean
     */
    protected function checkSiteMapPath()
    {
        try {
        $path=Yii::getAlias($this->sitemap_path);
        }catch (InvalidArgumentException $e){
            if(strpos($this->sitemap_path,'@frontend/web')!==false){
                $this->sitemap_path='@app/web';
                $path=Yii::getAlias($this->sitemap_path);
            }
        }
        return Dirs::dirExists($path);
    }
}