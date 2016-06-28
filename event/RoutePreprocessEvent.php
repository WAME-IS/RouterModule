<?php

namespace Wame\RouterModule\Event;

use Nette\Object,
	Wame\RouterModule\Routers\ActiveRoute;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 * 
 * @method ActiveRoute getRoute()
 * @method void setRoute(ActiveRoute $route)
 */
class RoutePreprocessEvent extends Object {

	/** @var ActiveRoute */
	public $route;

	public function __construct(ActiveRoute $route) {
		$this->route = $route;
	}

}
