<?php

namespace Wame\RouterModule\Event;

use Nette\Application\Routers\Route,
	Nette\Object;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 * 
 * @method Route getRoute()
 * @method void setRoute(Route $route)
 */
class RoutePostprocessEvent extends Object {

	/** @var Route */
	public $route;

	public function __construct(Route $route) {
		$this->route = $route;
	}
}
