<?php

namespace Wame\RouterModule\Filter;

use Kdyby\Events\Subscriber;
use Wame\RouterModule\Entities\RouterEntity;
use Wame\RouterModule\Event\RoutePreprocessEvent;
use Wame\RouterModule\Filter\IFilterHandler;
use Wame\RouterModule\Registers\FilterHandlersRegister;
use Wame\RouterModule\Routers\ActiveRoute;
use WebLoader\InvalidArgumentException;
use Nette\Application\Routers\Route;

/**
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class FilterListener implements Subscriber
{

    /** @var FilterHandlersRegister */
    private $filterHandlersRegister;

    public function __construct(FilterHandlersRegister $filterHandlersRegister)
    {
        $this->filterHandlersRegister = $filterHandlersRegister;
    }

    public function getSubscribedEvents()
    {
        return ['Wame\RouterModule\Routers\Router::onPreprocess'];
    }

    public function onPreprocess(RoutePreprocessEvent $event)
    {
        $route = $event->getRoute();
        $filters = $this->getFilters($route);
        if ($filters) {
            foreach ($filters as $filter) {
                $defaults = $route->defaults;
                $defaults[$filter->getParameterName()] = [
                    Route::FILTER_IN => function($in) use ($filter) {
                        return $filter->filterIn($in);
                    },
                    Route::FILTER_OUT => function($out) use ($filter) {
                        return $filter->filterOut($out);
                    },
                ];
                $route->defaults = $defaults;
            }
        }
    }

    /**
     * 
     * @param RouterEntity $route
     * @return IFilterHandler
     */
    private function getFilters(ActiveRoute $route)
    {
        if (isset($route->params['filter'])) {
            if (is_array($route->params['filter'])) {
                $filterHandlerRegister = $this->filterHandlersRegister;
                return array_map(function($name) use ($filterHandlerRegister) {
                    $filter = $filterHandlerRegister->getByName($name);
                    if (!$filter) {
                        throw new InvalidArgumentException("Invalid route filter name $name");
                    }
                    return $filter;
                }, $route->params['filter']);
            } else {
                $name = $route->params['filter'];
                $filter = $this->filterHandlersRegister->getByName($name);
                if (!$filter) {
                    throw new InvalidArgumentException("Invalid route filter name $name");
                }
                return [$filter];
            }
        }
    }
}
