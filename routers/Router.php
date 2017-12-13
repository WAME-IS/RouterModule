<?php

namespace Wame\RouterModule\Routers;

use Nette\Application\Routers\RouteList;
use Nette\DI\Container;
use Nette\Http\IRequest;
use Nette\Http\Request;
use Nette\Localization\ITranslator;
use Wame\LanguageModule\Repositories\LanguageRepository;
use Wame\RouterModule\Event\RoutePostprocessEvent;
use Wame\RouterModule\Event\RoutePreprocessEvent;
use Wame\RouterModule\Repositories\RouterRepository;
use Wame\RouterModule\Routers\ActiveRoute;


class Router extends RouteList
{
    /** @var RouterRepository */
    private $routerRepository;

    /** @var boolean */
    private $setuped;

    /**
     * Event called before creating route. Function accepts one argument of RoutePreprocessEvent type.
     * @var array
     */
    public $onPreprocess = [];

    /**
     * Event called after creating route. Function accepts one argument of RoutePreprocessEvent type.
     * @var array
     */
    public $onPostprocess = [];

    
    public function __construct(RouterRepository $routerRepository)
    {
        $this->routerRepository = $routerRepository;
    }

    
    public function setup()
    {
        if ($this->setuped) return;

        $this->setuped = true;

        foreach ($this->routerRepository->find(['status' => RouterRepository::STATUS_ENABLED], ['sort' => 'DESC']) as $route) {
            $activeRoute = new ActiveRoute($route);

            $routePreprocessEvent = new RoutePreprocessEvent($activeRoute);

            $this->onPreprocess($routePreprocessEvent);
            $activeRoute = $routePreprocessEvent->getRoute();

            if (!$activeRoute) {
                continue;
            }

            $activeRoute->createRoute();

            $routePostprocessEvent = new RoutePostprocessEvent($activeRoute);
            $this->onPostprocess($routePostprocessEvent);

            if (!$routePostprocessEvent->getRoute()) {
                continue;
            }

            $this[] = $routePostprocessEvent->getRoute();
        }
    }


    public function match(IRequest $httpRequest)
    {
        $this->setup();

        return parent::match($httpRequest);
    }
    
}
