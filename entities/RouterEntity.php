<?php

namespace Wame\RouterModule\Entities;

use Doctrine\ORM\Mapping as ORM,
	Nette\Application\Routers\Route,
	Wame\Core\Entities\BaseEntity,
	Wame\RouterModule\Routers\RouterEntityRoute;

/**
 * @ORM\Table(name="wame_router")
 * @ORM\Entity
 */
class RouterEntity extends BaseEntity {

	/**
	 * @ORM\Column(name="id", type="integer", length=2, nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	protected $id;

	/**
	 * @ORM\Column(name="route", type="string", length=255, nullable=false)
	 */
	protected $route;

	/**
	 * @ORM\Column(name="lang", type="string", length=2, nullable=false)
	 */
	protected $lang;

	/**
	 * @ORM\Column(name="module", type="string", length=50, nullable=false)
	 */
	protected $module;

	/**
	 * @ORM\Column(name="presenter", type="string", length=50, nullable=false)
	 */
	protected $presenter;

	/**
	 * @ORM\Column(name="action", type="string", length=250, nullable=false)
	 */
	protected $action;

	/**
	 * @ORM\Column(name="defaults", type="neon", length=512, nullable=true)
	 */
	protected $defaults;

	/**
	 * @ORM\Column(name="params", type="neon", length=512, nullable=true)
	 */
	protected $params;

	/**
	 * @ORM\Column(name="sort", type="integer", length=4, nullable=false)
	 */
	protected $sort;

	/**
	 * @ORM\Column(name="sitemap", type="integer", length=1, nullable=false)
	 */
	protected $sitemap;

	/**
	 * @ORM\Column(name="status", type="integer", length=1, nullable=false)
	 */
	protected $status;

	function getDefault($name) {
		if (array_key_exists($name, $this->defaults)) {
			return $this->defaults[$name];
		}
	}

	function setDefault($name, $value) {
		$this->defaults[$name] = $value;
	}

	/**
	 * 
	 * @return Route
	 */
	public function createRoute() {
		$data = [
			'presenter' => $this->presenter,
			'action' => $this->action
		];

		if ($this->module) {
			$data['module'] = $this->module;
		}

		$defaults = $this->defaults;

		if (is_array($defaults)) {
			$data = array_merge($defaults, $data);
		}

		$route = new RouterEntityRoute($this->route, $data);
		$route->setRouterEntity($this);
		return $route;
	}

}
