<?php

namespace Wame\RouterModule\Registers;

use Nette\Application\Routers\Route;

/**
 * RoutePostprocessor
 *
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
interface RoutePostprocessor {

	function process(Route $entity);
}
