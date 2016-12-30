<?php

namespace Wame\RouterModule\Registers;

use Wame\Core\Registers\BaseRegister;
use Wame\RouterModule\Entities\RouterEntity;
use Wame\RouterModule\Repositories\RouterRepository;
use h4kuna\Gettext\GettextSetup;

class DefaultRoutesRegister extends BaseRegister
{
    /** @var RouterRepository */
    private $routerRepository;

    /** @var GettextSetup */
    private $translator;


    public function __construct(RouterRepository $routerRepository, GettextSetup $translator)
    {
        parent::__construct(RouterEntity::class);
        $this->routerRepository = $routerRepository;
        $this->translator = $translator;
    }


    /**
     * Update routes table
     */
    public function updateRoutesTable()
    {
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

    /**
     * Add
     *
     * @param object $service
     * @param null $name
     */
    public function add($service, $name = null)
    {
        //if no lang is specified, use all langs
        if ($service->lang) {
            parent::add($service, $name);
        } else {
            foreach ($this->translator->getLanguages() as $lang => $spec) {
                $langEntry = clone $service;
                $langEntry->lang = $lang;
                parent::add($langEntry, $name . "-" . $lang);
            }
        }
    }

}
