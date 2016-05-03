<?php

namespace Wame\RouterModule\Model;

use Wame\Core\Registers\BaseRegister;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class DefaultRoutesRegister extends BaseRegister {
	
	/** @var Wame\RouterModule\Repositories\RouterRepository */
	private $routerRepository;
	
	public function __construct(\Wame\RouterModule\Repositories\RouterRepository $routerRepository) {
		parent::__construct(\Wame\RouterModule\Entities\RouterEntity::class);
		$this->routerRepository = $routerRepository;
	}
	
	public function updateRoutesDb() {
		foreach($this as $defaultRoute) {
			
			//TODO is this enought?
			$existingRoutes = $this->routerRepository->find([
				'module' => $defaultRoute->module,
				'presenter' => $defaultRoute->presenter,
				'action' => $defaultRoute->action
			]);
			
			if(count($existingRoutes) == 0) {
				$this->routerRepository->create($defaultRoute);
			}
		}
	}
	
}
