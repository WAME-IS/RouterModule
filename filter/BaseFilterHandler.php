<?php

namespace Wame\RouterModule\Filter;

use Nette\Object;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
abstract class BaseFilterHandler extends Object implements FilterHandler {

	public function getParameterName() {
		return "id";
	}
	
	public function isDeterministic() {
		return true;
	}

	public function toId($slug) {
		return $slug;
	}

	public function toSlug($id) {
		return $id;
	}
	
}
