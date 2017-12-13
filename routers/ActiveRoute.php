<?php

namespace Wame\RouterModule\Routers;

use Nette\Application\Request;
use Nette\Application\Routers\Route;
use Nette\Http\IRequest;
use Wame\RouterModule\Entities\RouterEntity;

class ActiveRoute extends Route
{
	/** @var RouterEntity */
	private $routerEntity;

	/* Route properties */
	public $route;
	public $module;
	public $presenter;
	public $action;
	public $defaults;
    public $params;
    public $lang;


	public function __construct(RouterEntity $routerEntity)
    {
		$this->routerEntity = $routerEntity;
		$this->route = $routerEntity->getRoute();
		$this->module = $routerEntity->getModule();
		$this->presenter = $routerEntity->getPresenter();
		$this->action = $routerEntity->getAction();
		$this->defaults = $routerEntity->getDefaults();
        $this->params = $routerEntity->getParams();
        $this->lang = $routerEntity->getLang();
	}


    /**
     * Create route
     */
	public function createRoute()
    {
		$metadata = [
			'presenter' => $this->presenter,
			'action' => $this->action
		];

		if ($this->module) {
			$metadata['module'] = $this->module;
		}

		if (is_array($this->defaults)) {
			$metadata = array_merge($this->defaults, $metadata);
		}
		
		parent::__construct($this->route, $metadata);
	}


	/** {@inheritdoc} */
    public function match(IRequest $httpRequest)
    {
        $request = parent::match($httpRequest);

        if ($request) {
            $activeRequest = new ActiveRequest($request->getPresenterName(), $request->getMethod(), $request->getParameters(), $request->getPost(), $request->getFiles());

            //copy flags
            foreach([Request::RESTORED, Request::SECURED] as $flag) {
                $activeRequest->setFlag($flag, $request->hasFlag($flag));
            }

            //set router entity
            $activeRequest->setRouterEntity($this->routerEntity);

            return $activeRequest;
        }
    }
    
}
