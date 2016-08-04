<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Forms;

use Wame\Core\Forms\FormFactory;
use Wame\RouterModule\Repositories\RouterRepository;
use Wame\RouterModule\Entities\RouterEntity;
use Nette\Security\User;

class RouterForm extends FormFactory
{
    /** @var RouterRepository */
    private $routerRepository;
    
    /** @var RouterEntity */
    public $routerEntity;
    
    
    public function __construct(RouterRepository $routerRepository, User $user)
    {
        $this->routerRepository = $routerRepository;
        $this->routerEntity = $routerRepository->get(['id' => $user->id]);
    }
    
    
    public function build()
	{
		$form = $this->createForm();
		
		if($this->id) {
			$form->addSubmit('submit', _('Update router'));
			$this->routerEntity = $this->routerRepository->get(['id' => $this->id]);
			$this->setDefaultValues();
		} else {
			$form->addSubmit('submit', _('Create router'));
		}
		
		$form->onSuccess[] = [$this, 'formSucceeded'];
		
		return $form;
	}
    
	public function create()
	{
		
	}

}
