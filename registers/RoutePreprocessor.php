<?php

namespace Wame\RouterModule\Registers;

use Wame\RouterModule\Entities\RouterEntity;

/**
 * RoutePreprocessor
 *
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
interface RoutePreprocessor {

	function process(RouterEntity $entity);
}
