<?php

namespace Wame\RouterModule\Filter;

use Nette\Object;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class BaseFilterHandler extends Object implements FilterHandler {

	public function getParameterName() {
		return "id";
	}

	public function toId($slug) {
		
	}

	public function toSlug($id) {
		
	}

	public function entityToSlug($entity) {
		
	}

}
