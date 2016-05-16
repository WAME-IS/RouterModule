<?php

namespace Wame\RouterModule\Routers;

use Nette\Application\Routers\RouteList,
	Wame\RouterModule\Event\RoutePostprocessEvent,
	Wame\RouterModule\Event\RoutePreprocessEvent,
	Wame\RouterModule\Repositories\RouterRepository;

class Router extends RouteList {

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

	public function __construct(RouterRepository $routerRepository) {

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

	public function match(\Nette\Http\IRequest $httpRequest) {
		$route = parent::match($httpRequest);
		\Tracy\Debugger::barDump($route);
		return $route;
	}
	
}
