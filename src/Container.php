<?php
namespace devskyfly\yiiExtension\sitemap;

use devskyfly\php56\types\Arr;
use yii\base\BaseObject;

class Container extends BaseObject
{
    /**
     *
     * @var ContainerItem[]
     */
    protected $list=[];
    
    /**
     * 
     * @param Page $item
     */
    public function insert(ContainerItem $item)
    {
        //if(Arr::keyExists($this->list, $item->route))
        $this->list[$item->route]=$item;
        return $this;
    }
    
    /**
     * 
     * @param string $key
     * @throws \OutOfBoundsException
     */
    public function remove($key)
    {
        if(!Arr::keyExists($this->list, $item->route)){
            throw new \OutOfBoundsException("Key '{$item->route}' does not exist");
        }
        
        unset($this->list[$item->route]);
        return $this;
    }
    
    /**
     *
     * @return Generator
     */
    public function getList()
    {
        $list=$this->list;
        
        foreach ($list as $item){
            yield $item;
        }
    }
}