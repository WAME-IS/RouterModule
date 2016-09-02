<?php

namespace Wame\RouterModule\Filter;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
interface IFilterHandler {
	
	/**
	 * Converts slug to id
	 * 
	 * @param mixed $in
	 * @return int Id
	 */
	public function filterIn($in);
	
	/**
	 * Converts id to slug
	 * 
	 * @param mixed $out
	 * @return string Slug
	 */
	public function filterOut($out);

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
