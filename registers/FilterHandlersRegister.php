<?php

namespace Wame\RouterModule\Registers;

use Wame\Core\Registers\BaseRegister;
use Wame\RouterModule\Filter\IFilterHandler;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class FilterHandlersRegister extends BaseRegister {

	public function __construct() {
		parent::__construct(IFilterHandler::class);
	}

}
