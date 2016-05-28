<?php

namespace Wame\RouterModule\Filter;

use App\Core\Presenters\BasePresenter,
	Nette\Application\Application,
	Nette\Application\UI\Presenter,
	Wame\Core\LinkEvent,
	Wame\RouterModule\Registers\FilterHandlersRegister,
	Wame\RouterModule\Routers\Router;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class FilterListener {

	/** @var FilterHandlersRegister */
	private $filterHandlersRegister;

	/** @var Router */
	private $router;

	public function __construct(FilterHandlersRegister $filterHandlersRegister, Application $application, Router $router) {
		$this->filterHandlersRegister = $filterHandlersRegister;
		$this->router = $router;

		$application->onPresenter[] = function($application, $presenter) {
			if ($presenter instanceof BasePresenter) {
				$lastRequest = $application->getRequests()[count($application->getRequests()) - 1];
				$this->serveFilterIn($presenter, $lastRequest);
				$presenter->onLink[] = function($event) use ($presenter) {
					dump("onLink");
					exit();
					$this->serveFilterOut($presenter, $event);
				};
			}
		};
	}

	/**
	 * Use filter by used presenter
	 * 
	 * @param Presenter $presenter
	 */
	private function serveFilterIn(Presenter $presenter, \Nette\Application\Request $request) {
		$filterHandler = $this->findFilterHandler($presenter);
		if ($filterHandler) {
			$paramName = $filterHandler->getParameterName();
			$params = $request->getParameters();

			if (!array_key_exists($paramName, $params)) {
				return;
			}

			$params[$paramName] = $filterHandler->toId($params[$paramName]);

			$request->setParameters($params);
		}
	}

	/**
	 * * Use filter by used presenter
	 * 
	 * @param Presenter $presenter
	 * @param LinkEvent $event
	 */
	private function serveFilterOut(Presenter $presenter, LinkEvent $event) {
		$filterHandler = $this->findFilterHandler($presenter);
		if ($filterHandler) {
			$paramName = $filterHandler->getParameterName();
			if (array_key_exists($paramName, $event->getArgs())) {
				$event->getArgs()[$paramName] = $filterHandler->toSlug($event->getArgs()[$paramName]);
			}
		}
	}

	/**
	 * Finds filter handler for given presenter
	 * 
	 * @param Presenter $presenter
	 * @return FilterHandler|NULL
	 */
	private function findFilterHandler(Presenter $presenter) {

		$activeRoute = $this->router->getActiveRoute();

		if ($activeRoute) {
			$params = $activeRoute->params;
			if (isset($params['filter'])) {
				$filterName = $params['filter'];
				return $this->filterHandlersRegister->getByName($filterName);
			}
		}

		return null;
	}

}
