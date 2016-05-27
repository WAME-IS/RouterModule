<?php

namespace Wame\RouterModule\Routers;

use Nette\Application\Request,
	Nette\Application\Routers\RouteList,
	Nette\Http\IRequest,
	Wame\RouterModule\Entities\RouterEntity,
	Wame\RouterModule\Event\RoutePostprocessEvent,
	Wame\RouterModule\Event\RoutePreprocessEvent,
	Wame\RouterModule\Repositories\RouterRepository;

class Router extends RouteList {

	/** @var RouterRepository */
	private $routerRepository;

	/** @var RouterEntity */
	private $activeRoute;

	/** @var boolean */
	private $setuped;

	/**
	 * Event called before creating route. Function accepts one argument of RoutePreprocessEvent type.
	 * @var array
	 */
	public $onPreprocess = [];

	/**
	 * Event called after creating route. Function accepts one argument of RoutePreprocessEvent type.
	 * @var array
	 */
	public $onPostprocess = [];

	public function __construct(RouterRepository $routerRepository) {
		$this->routerRepository = $routerRepository;
	}

	public function setup() {
		if ($this->setuped) {
			return;
		}
		$this->setuped = true;

		foreach ($this->routerRepository->find() as $route) {

			$routePreprocessEvent = new RoutePreprocessEvent($route);
			$this->onPreprocess($routePreprocessEvent);
			$route = $routePreprocessEvent->getRoute();
			if (!$route) {
				continue;
			}

			$netteRoute = $route->createRoute();

			$routePostprocessEvent = new RoutePostprocessEvent($netteRoute);
			$this->onPostprocess($routePostprocessEvent);
			if (!$routePostprocessEvent->getRoute()) {
				continue;
			}

			$this[] = $routePostprocessEvent->getRoute();
		}
	}

	/**
	 * Maps HTTP request to a Request object.
	 * @return Request|NULL
	 */
	public function match(IRequest $httpRequest) {
		$this->setup();

		foreach ($this as $route) {
			$appRequest = $route->match($httpRequest);
			if ($appRequest !== NULL) {
				$name = $appRequest->getPresenterName();
				if (strncmp($name, 'Nette:', 6)) {
					$appRequest->setPresenterName($this->module . $name);
				}
				if ($route instanceof RouterEntityRoute) {
					$this->activeRoute = $route->getRouterEntity();
				}
				return $appRequest;
			}
		}

		return NULL;
	}

	/**
	 * Returns used RouterEntity
	 * @return RouterEntity
	 */
	public function getActiveRoute() {
		return $this->activeRoute;
	}

}
