<?php

namespace Wame\RouterModule\Repositories;

use Nette\Application\UI\Presenter;
use Wame\Core\Repositories\BaseRepository;
use Wame\RouterModule\Entities\RouterEntity;


class RouterRepository extends BaseRepository
{
	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;


	public function __construct()
    {
		parent::__construct(RouterEntity::class);
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

		return parent::find($criteria, $orderBy, $limit, $offset);
	}


    /**
     * Create route
     * 
     * @param RouterEntity $entity
     */
	public function create(RouterEntity $entity)
    {
		$this->entityManager->persist($entity);
		$this->entityManager->flush();
	}


    /**
     * Update route
     *
     * @param RouterEntity $routeEntity
     * @return RouterEntity
     */
	public function update(RouterEntity $routeEntity)
    {
		return $routeEntity;
	}


	/**
	 *
	 * @param Presenter $presenter
	 * @return RouterEntity
	 */
	public function byPresenter(Presenter $presenter)
    {
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
