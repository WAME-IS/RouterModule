<?php

namespace Wame\RouterModule\Model;

use Wame\Core\Registers\BaseRegister,
	Wame\RouterModule\Entities\RouterEntity,
	Wame\RouterModule\Repositories\RouterRepository;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class DefaultRoutesRegister extends BaseRegister {

	/** @var RouterRepository */
	private $routerRepository;

	/** @var h4kuna\Gettext\GettextSetup */
	private $translator;

	public function __construct(RouterRepository $routerRepository, \h4kuna\Gettext\GettextSetup $translator) {
		parent::__construct(RouterEntity::class);
		$this->routerRepository = $routerRepository;
		$this->translator = $translator;
	}

	public function updateRoutesTable() {
		foreach ($this as $defaultRoute) {

			$existingRoutes = $this->routerRepository->find([
				'lang' => $defaultRoute->lang,
				'module' => $defaultRoute->module,
				'presenter' => $defaultRoute->presenter,
				'action' => $defaultRoute->action
			]);
			
			if (count($existingRoutes) == 0) {
				$this->routerRepository->create($defaultRoute);
			}
		}
	}

	public function register($entry) {
		//if no lang is specified, use all langs
		if ($entry->lang) {
			parent::register($entry);
		} else {
			foreach ($this->translator->getLanguages() as $lang => $spec) {
				$langEntry = clone $entry;
				$langEntry->lang = $lang;
				parent::register($langEntry);
			}
		}
	}

}
