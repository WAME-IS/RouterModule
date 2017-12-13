<?php

namespace Wame\RouterModule\Entities;

use Doctrine\ORM\Mapping as ORM;
use Wame\Core\Entities\BaseEntity;
use Wame\RouterModule\Routers\RouterEntityRoute;

/**
 * @ORM\Table(name="wame_router")
 * @ORM\Entity
 */
class RouterEntity extends BaseEntity
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
	protected $sort = 0;

	/**
	 * @ORM\Column(name="sitemap", type="integer", length=1, nullable=false)
	 */
	protected $sitemap = 1;

	/**
	 * @ORM\Column(name="status", type="integer", length=1, nullable=false)
	 */
	protected $status = 1;
    
    /**
     * @ORM\ManyToOne(targetEntity="RouterEntity", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
	protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="RouterEntity", mappedBy="parent")
     */
	protected $children;
    
    
    public function getLink()
    {
        $module = $this->module;
        $presenter = $this->presenter;
        $action = $this->action;

        return ":$module:$presenter:$action";
    }
    
}
