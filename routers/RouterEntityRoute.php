<?php

namespace Wame\RouterModule\Routers;

use Nette\Application\Routers\Route,
	Wame\RouterModule\Entities\RouterEntity;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class RouterEntityRoute extends Route {

	/** @var RouterEntity */
	private $routerEntity;

	function getRouterEntity() {
		return $this->routerEntity;
	}

	function setRouterEntity(RouterEntity $routerEntity) {
		$this->routerEntity = $routerEntity;
	}

}
