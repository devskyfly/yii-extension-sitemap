<?php

namespace devskyfly\yiiExtensionSitemap;

use devskyfly\php56\libs\fileSystem\Dirs;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Str;
use yii\base\BaseObject;

/**
 * @property string $fileName
 */
class Generator extends BaseObject
{
    /**
     * @var string
     */
    public $path = "@frontend/web/";

    /**
     *
     * @var array
     */
    public $list = [];

    /**
     *
     * @var integer
     */
    public $itemsInFile = 10000;

    /**
     *
     * @var string
     */
    public  $fileName = "sitemap.xml";

    public function init()
    {
        parent::init();

        if (!Str::isString($this->path)) {
            throw new SitemapException("Propery 'path' is not string type.");
        }

        $this->path = \Yii::getAlias($this->path);

        if (!Dirs::dirExists(\Yii::getAlias($this->path))) {
            throw new SitemapException("Directory '{$this->path}' does not exist.");
        }

        if (!Str::isString($this->fileName)) {
            throw new SitemapException("Property fileName is not string type.");
        }

        if (!Nmbr::isInteger($this->itemsInFile)) {
            throw new SitemapException('Property $itemsInFile is not integer type.');
        }
    }

    /**
     * End define getters and setters
     *******************************/

    public function generate()
    {
        $fileProps = explode(".", $this->fileName);

        if (count($fileProps) != 2) {
            throw new SitemapException("File props size is not equal to 2.");
        }

        if ($fileProps[1] !== "xml") {
            throw new Sitemap("File extension is not 'xml'.");
        }

        $name = $fileProps[0];
        $extension = $fileProps[1];
        $path = $this->path."/".$name.".".$extension;

        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->startDocument('1.0', 'UTF-8');
        $xmlWriter->startElement('urlset');
        $xmlWriter->writeAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");

        $part = 0;
        $i = 0;
        foreach ($this->list as $item) {
            $i++;
            $xmlWriter->startElement('url');
            $xmlWriter->writeElement('loc', $item->url);
            $xmlWriter->writeElement('lastmod', (new \DateTime($item->date_time))->format("Y-m-d"));
            $xmlWriter->writeElement('priority', $item->priority);
            $xmlWriter->endElement();

            // Flush XML in memory to file every 1000 iterations
            if (0 == $i%$this->itemsInFile) {
                if ($part > 0) {
                    $path = $name."_".$part.".".$extension;
                }

                $result = file_put_contents($path, $xmlWriter->flush(true), FILE_APPEND);

                if (!$result) {
                    throw new SitemapException("Can't write file {$path}.");
                }
                $part++;
            }
        }
        $xmlWriter->endElement();
        // Final flush to make sure we haven't missed anything
        $result = file_put_contents($path, $xmlWriter->flush(true), FILE_APPEND);
        
        if (!$result) {
            throw new SitemapException("Can't write file {$path}.");
        }
    }
}