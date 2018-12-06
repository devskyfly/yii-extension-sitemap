<?php
namespace devskyfly\yiiExtension\sitemap;

use devskyfly\php56\libs\fileSystem\Dirs;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;

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
     * @var yii\httpclient\Client
     */
    public $client=null;
    
    
    public function init()
    {
        parent::init();
        
        $this->checkSiteMapPath();
    }
    
    /**
     *
     * @return \devskyfly\yiiModuleAdminPanel\helpers\sitemap\Generator
     */
    public function getPages()
    {
        return $this->container->getList();
    }
    
    /**
     * @todo Nead to realize
     */
    public function generateXml()
    {
        $generator=$this->getPages();
        foreach ($generator as $item){
            
        }
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