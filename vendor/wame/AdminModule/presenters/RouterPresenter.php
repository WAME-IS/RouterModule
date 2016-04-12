<?php

namespace App\AdminModule\Presenters;

use Wame\RouterModule\Entities\RouterEntity;
use Wame\RouterModule\Repositories\RouterRepository;

class RouterPresenter extends BasePresenter
{	
	/** @var RouterEntity */
	private $routerEntity;
	
	public function startup() 
	{
		parent::startup();
		
		if (!$this->user->isAllowed('router', 'view')) {
			$this->flashMessage(_('To enter this section you have sufficient privileges.'), 'danger');
			$this->redirect('parent');
		}
		
		$this->routerEntity = $this->entityManager->getRepository(RouterEntity::class);
	}

	public function renderDefault()
	{
		$this->template->siteTitle = _('Routes');
		$this->template->routerEntity = $this->routerEntity->findBy(['status' => RouterRepository::STATUS_ACTIVE]);
	}

}
