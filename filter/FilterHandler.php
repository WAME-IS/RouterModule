<?php

namespace Wame\RouterModule\Filter;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
interface FilterHandler {

	/**
	 * Converts id to slug
	 * 
	 * @param int $id
	 * @return string Slug
	 */
	public function toSlug($id);

	/**
	 * COnverts enditty to slug
	 * 
	 * @param \Wame\Core\Entities\BaseEntity $entity
	 * @return string Slug
	 */
	public function entityToSlug($entity);

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
}
