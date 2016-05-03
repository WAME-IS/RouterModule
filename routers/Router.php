<?php

namespace Wame\RouterModule\Routers;

use Nette\Application\Routers\RouteList,
	Wame\RouterModule\Registers\RoutePostprocessorRegister,
	Wame\RouterModule\Registers\RoutePreprocessorRegister,
	Wame\RouterModule\Repositories\RouterRepository;

class Router extends RouteList {

	public function __construct(RouterRepository $routerRepository, RoutePreprocessorRegister $routePreprocessorRegister, RoutePostprocessorRegister $routePostprocessorRegister) {

		foreach ($routerRepository->find() as $route) {

			foreach ($routePreprocessorRegister as $preprocessor) {
				$preprocessor->process($route);
			}

			$netteRoute = $route->createRoute();

			foreach ($routePostprocessorRegister as $postprocessor) {
				$postprocessor->process($netteRoute);
			}

			$this[] = $netteRoute;
		}
	}

}
