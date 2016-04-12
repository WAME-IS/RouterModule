<?php

namespace Wame;

use Wame\Core\Models\Plugin;
use Wame\PermissionModule\Models\PermissionObject;

class RouterModule extends Plugin 
{
	/** @var PermissionObject */
	private $permission;

	public function __construct(PermissionObject $permission) 
	{
		$this->permission = $permission;
	}
	
	public function onEnable() 
	{
		$this->permission->addResource('router');
		$this->permission->addResourceAction('router', 'view');
		$this->permission->allow('admin', 'router', 'view');
		$this->permission->addResourceAction('router', 'add');
		$this->permission->allow('admin', 'router', 'add');
		$this->permission->addResourceAction('router', 'edit');
		$this->permission->allow('admin', 'router', 'edit');
		$this->permission->addResourceAction('router', 'delete');
		$this->permission->allow('admin', 'router', 'delete');
	}

}
