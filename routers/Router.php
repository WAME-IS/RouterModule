<?php

namespace Wame\RouterModule\Routers;

use h4kuna\Gettext\GettextSetup,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\RouteList;

class Router extends RouteList {

	public function __construct(GettextSetup $translator) {
		//TODO load from route repository
	}
}
