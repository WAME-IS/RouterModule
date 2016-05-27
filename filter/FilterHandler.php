<?php

namespace Wame\RouterModule\Filter;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
interface FilterHandler {

	/**
	 * Returns name of filter
	 * 
	 * @return string Name of filter
	 */
	public function getName();
	
	/**
	 * Converts id to slug
	 * 
	 * @param int $id
	 * @return string Slug
	 */
	public function toSlug($id);

	/**
	 * Converts slug to id
	 * 
	 * @param string $slug
	 * @return int Id
	 */
	public function toId($slug);

	/**
	 * Name of parameter used for loading slug
	 * 
	 * @return string
	 */
	public function getParameterName();
	
	/**
	 * Whenever this filter is deterministic or not. Deterministic filters are cached and put into history table.
	 * 
	 * @return boolean
	 */
	public function isDeterministic();
	
}
