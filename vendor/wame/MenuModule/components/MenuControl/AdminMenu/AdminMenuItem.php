<?php

namespace Wame\RouterModule\Vendor\Wame\MenuModule\Components\MenuControl\AdminMenu;

use Nette\Application\LinkGenerator;
use Wame\MenuModule\Models\Item;

interface IAdminMenuItem
{
	/** @return AdminMenuItem */
	public function create();
}


class AdminMenuItem implements \Wame\MenuModule\Models\IMenuItem
{	
    /** @var LinkGenerator */
	private $linkGenerator;
	
	
	public function __construct(
		LinkGenerator $linkGenerator
	) {
		$this->linkGenerator = $linkGenerator;
	}

	
	public function addItem()
	{
        $item = new Item();
		$item->setName('router');
		$item->setTitle(_('Routers'));
        $item->setLink($this->linkGenerator->link('Admin:Router:', ['id' => null]));
        $item->setIcon('fa fa-compass');
		$item->addNode($this->routersDefault());
		
		return $item->getItem();
	}
	
	
	private function routersDefault()
	{
		$item = new Item();
		$item->setName('router-routers');
		$item->setTitle(_('Routers'));
		$item->setLink($this->linkGenerator->link('Admin:Router:', ['id' => null]));
		
		return $item->getItem();
	}

}
