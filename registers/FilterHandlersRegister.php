<?php

namespace Wame\RouterModule\Registers;

use Wame\Core\Registers\BaseRegister,
	Wame\RouterModule\Filter\FilterHandler;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class FilterHandlersRegister extends BaseRegister {

	public function __construct() {
		parent::__construct(FilterHandler::class);
	}

}
