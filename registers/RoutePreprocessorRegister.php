<?php

namespace Wame\RouterModule\Registers;

use Wame\Core\Registers\BaseRegister,
	Wame\RouterModule\Registers\RoutePreprocessor;

/**
 * RoutePreprocessorRegistry
 *
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class RoutePreprocessorRegister extends BaseRegister {

	public function __construct() {
		parent::__construct(RoutePreprocessor::class);
	}

}
