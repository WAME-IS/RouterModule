<?php

namespace Wame\RouterModule\Repositories;

use Wame\RouterModule\Entities\RouterEntity;

class RouterRepository extends \Wame\Core\Repositories\BaseRepository
{
	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;
	
	/** @var RouterEntity */
	private $routerEntity;
	
	public function __construct(\Nette\DI\Container $container, \Kdyby\Doctrine\EntityManager $entityManager, \h4kuna\Gettext\GettextSetup $translator, \Nette\Security\User $user) {
		parent::__construct($container, $entityManager, $translator, $user);
		
		$this->routerEntity = $entityManager->getRepository(RouterEntity::class);
	}
	
	/**
	 * 
	 * @param type $module
	 * @param type $presenter
	 * @param type $action
	 * @return RouterEntity
	 */
	public function getRoute($module, $presenter, $action) 
	{
		return $this->routerEntity->findOneBy([
			'status' => self::STATUS_ENABLED,
			'module'=> $module,
			'presenter' => $presenter,
			'action' => $action
		], ['sort' => 'ASC']);
	}

}