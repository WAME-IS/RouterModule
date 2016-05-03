<?php

namespace Wame\RouterModule\Event;

use Nette\Object,
	Wame\RouterModule\Entities\RouterEntity;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 * 
 * @method RouterEntity getRoute()
 * @method void setRoute(RouterEntity $route)
 */
class RoutePreprocessEvent extends Object {

	/** @var RouterEntity */
	public $route;

	public function __construct(RouterEntity $route) {
		$this->route = $route;
	}

}
