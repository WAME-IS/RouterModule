<?php

namespace Wame\RouterModule\Filter;

use Nette\Application\Routers\Route,
	Wame\RouterModule\Entities\RouterEntity,
	Wame\RouterModule\Event\RoutePreprocessEvent,
	Wame\RouterModule\Registers\FilterHandlersRegister,
	Wame\RouterModule\Routers\ActiveRoute,
	Wame\RouterModule\Routers\Router;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class FilterListener {

	/** @var FilterHandlersRegister */
	private $filterHandlersRegister;

	public function __construct(Router $router, FilterHandlersRegister $filterHandlersRegister) {
		$this->filterHandlersRegister = $filterHandlersRegister;
		$router->onPreprocess[] = function(RoutePreprocessEvent $event) {
			$this->onPreprocess($event->getRoute());
		};
	}

	private function onPreprocess(ActiveRoute $route) {
		$filters = $this->getFilters($route);
		if ($filters) {
			foreach ($filters as $filter) {
				$defaults = $route->defaults;
				$defaults[$filter->getParameterName()] = [
					Route::FILTER_IN => function($in) use ($filter) {
						return $filter->filterIn($in);
					},
					Route::FILTER_OUT => function($out) use ($filter) {
						return $filter->filterOut($out);
					},
				];
				$route->defaults = $defaults;
			}
		}
	}

	/**
	 * 
	 * @param RouterEntity $route
	 * @return IFilterHandler
	 */
	private function getFilters(ActiveRoute $route) {
		if (isset($route->params['filter'])) {
			if (is_array($route->params['filter'])) {
				$filterHandlerRegister = $this->filterHandlersRegister;
				return array_map(function($name) use ($filterHandlerRegister) {
					return $filterHandlerRegister->getByName($name);
				}, $route->params['filter']);
			} else {
				return [$this->filterHandlersRegister->getByName($route->params['filter'])];
			}
		}
	}

}
