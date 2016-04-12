<?php

namespace Wame\RouterModule\Entities;

use Doctrine\ORM\Mapping as ORM;
use Nette\Neon\Neon;
use Nette\Application\Routers\Route;

/**
 * @ORM\Table(name="wame_router")
 * @ORM\Entity
 */
class RouterEntity extends \Wame\Core\Entities\BaseEntity 
{
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
	 * @ORM\Column(name="defaults", type="string", length=255, nullable=false)
	 */
	protected $defaults;

	/**
	 * @ORM\Column(name="sort", type="integer", length=4, nullable=false)
	 */
	protected $sort;

	/**
	 * @ORM\Column(name="sitemap", type="integer", length=1, nullable=false)
	 */
	protected $sitemap;

	/**
	 * @ORM\Column(name="status", type="integer", length=1, nullable=true)
	 */
	protected $status;

	/**
	 * @ORM\Column(name="parent", type="integer", length=11, nullable=false)
	 */
	protected $parentRoute;

	public function generateRoute() 
	{
		$data = [
			'presenter' => $this->presenter,
			'action' => $this->action
		];

		if ($this->module) {
			$data['module'] = $this->module;
		}
		
		$defaults = Neon::decode($this->defaults);
		
		if (is_array($defaults)) {
			$data = array_merge($defaults, $data);
		}
		
		return new Route($this->path, $data);
	}
	
}
