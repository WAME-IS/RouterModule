<?php

namespace Wame\RouterModule\Routers;

use Nette\Application\Routers\Route;
use Nette\Http\IRequest;
use Wame\RouterModule\Entities\RouterEntity;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class ActiveRoute extends Route {

	/** @var RouterEntity */
	private $routerEntity;

	/*
	 * Route properties
	 */
	public $route;
	public $module;
	public $presenter;
	public $action;
	public $defaults;
	public $params;

	public function __construct(RouterEntity $routerEntity) {
		$this->routerEntity = $routerEntity;
		$this->route = $routerEntity->route;
		$this->module = $routerEntity->module;
		$this->presenter = $routerEntity->presenter;
		$this->action = $routerEntity->action;
		$this->defaults = $routerEntity->defaults;
		$this->params = $routerEntity->params;
	}
	
	public function createRoute() {
		
		$metadata = [
			'presenter' => $this->presenter,
			'action' => $this->action,
            'filter' => [
//                \Nette\Application\Routers\Route::FILTER_IN => function($string) {
//                    \Tracy\Debugger::barDump($string, "in");
////                    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
////                    $replacements = array('!', '*', "'", "(", ")", ";", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
////                    return str_replace($entities, $replacements, $string);
//                    
//                    return $string;
//                },
                \Nette\Application\Routers\Route::FILTER_OUT => function($string) {
                    \Tracy\Debugger::barDump("out");
                    
                    return $string;
                }
            ]
		];

		if ($this->module) {
			$metadata['module'] = $this->module;
		}

		if (is_array($this->defaults)) {
			$metadata = array_merge($this->defaults, $metadata);
		}
		
		parent::__construct($this->route, $metadata);
	}

    public function match(IRequest $httpRequest)
    {
        $request = parent::match($httpRequest);
        if($request) {
            $activeRequest = new ActiveRequest($request->getPresenterName(), $request->getMethod(), $request->getParameters(), $request->getPost(), $request->getFiles());
            //copy flags
            foreach([\Nette\Application\Request::RESTORED, \Nette\Application\Request::SECURED] as $flag) {
                $activeRequest->setFlag($flag, $request->hasFlag($flag));
            }
            //set router entity
            $activeRequest->setRouterEntity($this->routerEntity);
            return $activeRequest;
        }
    }
}
