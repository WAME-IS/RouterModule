<?php

namespace Wame\RouterModule\Repositories;

use h4kuna\Gettext\GettextSetup,
	Kdyby\Doctrine\EntityManager,
	Nette\DI\Container,
	Nette\Security\User,
	Wame\Core\Repositories\BaseRepository,
	Wame\RouterModule\Entities\RouterEntity;

class RouterRepository extends BaseRepository {

	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;

	/** @var RouterEntity */
	private $routerEntity;

	public function __construct(Container $container, EntityManager $entityManager, GettextSetup $translator, User $user) {
		parent::__construct($container, $entityManager, $translator, $user);

		$this->routerEntity = $entityManager->getRepository(RouterEntity::class);
	}

	/**
	 * Find all routes by criteria
	 * 
	 * @param array $criteria
	 * @return RouterEntity[] routes
	 */
	public function find($criteria = array(), $orderBy = null, $limit = null, $offset = null) {
		
		dump(\Doctrine\DBAL\Types\Type::getTypesMap());
		
		if(!$orderBy) {
			$orderBy = ['sort'=>'desc'];
		}
		
		return $this->routerEntity->findBy($criteria, $orderBy, $limit, $offset);
	}

}
