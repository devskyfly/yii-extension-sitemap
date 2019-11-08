<?php
namespace devskyfly\yiiExtensionSitemap;

use Yii;
use devskyfly\php56\libs\fileSystem\Dirs;
use yii\base\BaseObject;
use devskyfly\php56\types\Obj;
use devskyfly\yiiExtensionSitemap\console\SitemapController;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;

class Sitemap extends BaseObject implements BootstrapInterface
{
    /**
     *
     * @var string
     */
    public $path='@frontend/web';
    
    /**
     * 
     * @var Container
     */
    public $container = null;

    public function init()
    {
        parent::init();
        if (!(Obj::isA($this->container, Container::class))) {
            $this->container = Yii::createObject($this->container);
        }
        $this->initPath();
    }

    public function bootstrap($app)
    {
        if ($app instanceof ConsoleApplication) {
            $app->controllerMap['sitemap'] = ["class" => SitemapController::class];
        }
    }
    
    /**
     *
     * @throws yii\base\InvalidArgumentException
     * @return boolean
     */
    protected function initPath()
    {
        $path = Yii::getAlias($this->path);
        
        if (!Dirs::dirExists($path)) {
            throw new SitemapException("Path '{$path}' does not exist.");
        }
    }

    public function generate()
    {
        $pages = $this->container->getAllPages();
        foreach ($pages as $page) {
            
        }
    }    
}