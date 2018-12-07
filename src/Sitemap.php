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
     * @var yii\httpclient\Request
     */
    public $request=null;
    
    
    public function init()
    {
        parent::init();
        
        
        if(Vrbl::isNull($this->request)){
            $this->request=(new Client())->createRequest();
            $this->request->setMethod('GET');
        }else{
            if(!Obj::isA($this->request, Request::class)){
                throw new \InvalidArgumentException('Property $request is not '.Request::class.' class.');
            }
        }
        
        $this->checkSiteMapPath();
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