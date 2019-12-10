<?php
namespace devskyfly\yiiExtensionSitemap;

use Yii;
use devskyfly\php56\libs\fileSystem\Dirs;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiExtensionSitemap\console\SitemapController;
use yii\base\BaseObject;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;

class Sitemap extends BaseObject implements BootstrapInterface
{
    private static $instance = null;

    /**
     *
     * @var string
     */
    public $path = '@frontend/web/';
    
    /**
     * 
     * @var Container
     */
    public $container = null;

    /**
     * 
     * @var Logger
     */
    public $logger = null; 

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
        
        if (Vrbl::isNull(self::$instance)) {
            self::$instance = $this;
        }

        if (!(Obj::isA($this->container, Container::class))) {
            $this->container = Yii::createObject($this->container);
        }

        $this->logger =  new Logger();
        
        $this->initPath();
    }

    /**
     *
     * @return Sitemap
     */
    public static function getInstance() 
    {
        if (!Vrbl::isNull(self::$instance)) {
            return self::$instance;
        } else {
            return new self();
        }
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
        $this->path = Yii::getAlias($this->path);
        
        if (!Dirs::dirExists($this->path)) {
            throw new SitemapException("Path '{$this->path}' does not exist.");
        }
    }

    public function generate()
    {
        $pages = $this->container->getAllPages();
        
        $generator = new Generator([
            'fileName' => "sitemap.xml",
            'list' => $pages,
            'path' => $this->path
        ]);

        $generator->generate();
    }    
}