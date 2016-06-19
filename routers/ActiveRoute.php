<?php

namespace Wame\RouterModule\Routers;

use Nette\Application\Routers\Route,
	Wame\RouterModule\Entities\RouterEntity;

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

}
