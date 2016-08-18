<?php

namespace Wame\RouterModule\Routers;

class ActiveRequest extends \Nette\Application\Request
{
    
    /** @var \Wame\RouterModule\Entities\RouterEntity */
    private $routerEntity;
    
    public function __construct($name, $method = NULL, $params = array(), $post = array(), $files = array(), $flags = array())
    {
        parent::__construct($name, $method, $params, $post, $files, $flags);
    }
    
    function getRouterEntity()
    {
        return $this->routerEntity;
    }

    function setRouterEntity(\Wame\RouterModule\Entities\RouterEntity $routerEntity)
    {
        $this->routerEntity = $routerEntity;
    }
    
}
