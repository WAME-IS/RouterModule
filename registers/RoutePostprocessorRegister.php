<?php

namespace Wame\RouterModule\Registers;

use Wame\Core\Registers\BaseRegister;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class RoutePostprocessorRegister extends BaseRegister {

	public function __construct() {
		parent::__construct(RoutePostprocessor::class);
	}

}
