<?php

namespace Wame\RouterModule\Filter;

use Nette\Application\Application,
	Nette\Application\UI\Presenter,
	Wame\Core\Entities\BaseEntity,
	Wame\Core\LinkEvent,
	Wame\SeoModule\Registers\SlugHandler,
	Wame\SeoModule\Registers\SlugHandlersRegister;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class FilterListener {

	/** @var \Wame\RouterModule\Registers\FilterHandlersRegister */
	private $filterHandlersRegister;

	public function __construct(\Wame\RouterModule\Registers\FilterHandlersRegister $filterHandlersRegister, Application $application) {
		$this->filterHandlersRegister = $filterHandlersRegister;

		$application->onPresenter = function($application, $presenter) {
			$this->serveFilterIn($presenter);
			$presenter->onLink[] = function($event) use ($presenter) {
				$this->serveFilterOut($presenter, $event);
			};
		};
	}

	/**
	 * Convert slug to id on load of presenter
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

			$params[$paramName] = $slugHandler->toId($params[$paramName]);

			$presenter->getRequest()->setParameters($params);
		}
	}

	/**
	 * Convert slug to id on load of presenter
	 * 
	 * @param Presenter $presenter
	 */
	private function serveFilterOut(Presenter $presenter, LinkEvent $event) {
		$slugHandler = $this->findFilterHandler($presenter);
		if ($slugHandler) {
			$paramName = $slugHandler->getParameterName();
			if (array_key_exists($paramName, $event->getArgs())) {
				$event->getArgs()[$paramName] = $this->paramToSlug($slugHandler, $event->getArgs()[$paramName]);
			}
		}
	}

	/**
	 * 
	 * @param mixed $param
	 */
	private function paramToSlug(SlugHandler $slugHandler, $param) {
		if (is_object($param) && $param instanceof BaseEntity) {
			return $slugHandler->entityToSlug($param);
		}
		if (is_int($param)) {
			return $slugHandler->toSlug($param);
		}
	}

	/**
	 * Finds filter handler for given presenter
	 * 
	 * @param Presenter $presenter
	 * @return SlugHandler|NULL
	 */
	private function findFilterHandler(Presenter $presenter) {
		$module = NULL;
		if (method_exists($presenter, 'getModule')) {
			$module = $presenter->getModule();
		}

		//TODO used route?!?
		
		/*
		foreach ($this->slugHandlersRegister as $slugHandler) {
			if ($slugHandler->match($module, $presenter->getName(), $presenter->getAction())) {
				return $slugHandler;
			}
		}
		 */
	}

}
