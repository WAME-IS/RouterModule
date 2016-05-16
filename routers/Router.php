<?php

namespace Wame\RouterModule\Routers;

use Nette\Application\Routers\RouteList,
	Nette\Http\IRequest,
	Wame\RouterModule\Entities\RouterEntity,
	Wame\RouterModule\Event\RoutePostprocessEvent,
	Wame\RouterModule\Event\RoutePreprocessEvent,
	Wame\RouterModule\Repositories\RouterRepository;

class Router extends RouteList {

	/** @var IRequest */
	private $httpRequest;

	/** @var RouterEntity */
	private $activeRoute;

	/**
	 * Event called before creating route. Function accepts one argument of RoutePreprocessEvent type.
	 * @var array
	 */
	public $onPreprocess;

	/**
	 * Event called after creating route. Function accepts one argument of RoutePreprocessEvent type.
	 * @var array
	 */
	public $onPostprocess;

	public function __construct(RouterRepository $routerRepository, IRequest $httpRequest) {
		$this->httpRequest = $httpRequest;

		foreach ($routerRepository->find() as $route) {

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
	 * Returns used RouterEntity
	 * @return RouterEntity
	 */
	public function getActiveRoute() {
		if (!$this->activeRoute) {
			foreach ($this as $route) {
				if ($route->match($this->httpRequest) !== NULL) {
					$this->activeRoute = $route->getRouterEntity();
				}
			}
		}
		return $this->activeRoute;
	}

}
