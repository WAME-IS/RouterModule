<?php

namespace Wame\RouterModule\Filter;

use Nette\Application\Application,
	Nette\Application\UI\Presenter,
	Wame\Core\Entities\BaseEntity,
	Wame\Core\LinkEvent;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class FilterListener {

	/** @var \Wame\RouterModule\Registers\FilterHandlersRegister */
	private $filterHandlersRegister;

	/** @var \Wame\RouterModule\Routers\Router */
	private $router;

	public function __construct(\Wame\RouterModule\Registers\FilterHandlersRegister $filterHandlersRegister, Application $application, \Wame\RouterModule\Routers\Router $router) {
		$this->filterHandlersRegister = $filterHandlersRegister;
		$this->router = $router;

		$application->onPresenter = function($application, $presenter) {
			if ($presenter instanceof \App\Core\Presenters\BasePresenter) {
				$this->serveFilterIn($presenter);
				$presenter->onLink[] = function($event) use ($presenter) {
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
	private function serveFilterIn(Presenter $presenter) {
		$filterHandler = $this->findFilterHandler($presenter);
		if ($filterHandler) {
			$paramName = $filterHandler->getParameterInName();
			$params = $presenter->getRequest()->getParameters();

			if (!array_key_exists($paramName, $params)) {
				return;
			}

			$params[$paramName] = $filterHandler->toId($params[$paramName]);

			$presenter->getRequest()->setParameters($params);
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
		/*
		  $activeRoute = $this->router->getActiveRoute();
		  if($activeRoute) {
		  $params = $activeRoute->params;
		  if(isset($params['filter'])) {
		  $filterClass = $params['filter'];
		  class_exists($filterClass)
		  }
		  }
		 */
		return null;
	}

}
