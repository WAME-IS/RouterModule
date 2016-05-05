<?php

namespace Wame\RouterModule\Repositories;

use Doctrine\DBAL\Types\Type,
	h4kuna\Gettext\GettextSetup,
	Kdyby\Doctrine\EntityManager,
	Nette\Application\UI\Presenter,
	Nette\DI\Container,
	Nette\Security\User,
	Wame\Core\Repositories\BaseRepository,
	Wame\RouterModule\Entities\RouterEntity;
use function dump;

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

		if (!$orderBy) {
			$orderBy = ['sort' => 'desc'];
		}

		return $this->routerEntity->findBy($criteria, $orderBy, $limit, $offset);
	}

	/**
	 * 
	 * @param Presenter $presenter
	 * @return RouterEntity
	 */
	public function byPresenter(Presenter $presenter) {

		$module = NULL;
		if (method_exists($presenter, 'getModule')) {
			$module = $presenter->getModule();
		}

		$full = $this->find([
			'module' => $module,
			'presenter' => $presenter->getName(),
			'action' => $presenter->getAction()
		]);

		return $full;
	}

}
