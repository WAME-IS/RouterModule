<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Containers\BaseContainer;


interface IRouteContainerFactory extends IBaseContainer
{
	/** @return RouteContainer */
	public function create();
}


class RouteContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure()
	{
		$this->addText('route', _('Route'))
				->setRequired(_('Please enter route'));
    }


    /** {@inheritDoc} */
	public function setDefaultValues($entity)
	{
        $this['route']->setDefaultValue($entity->getRoute());
	}


    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setRoute($values['route']);
    }

}
