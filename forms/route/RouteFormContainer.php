<?php

namespace Wame\RouterModule\Forms;

use Wame\DynamicObject\Forms\BaseFormContainer;


interface IRouteFormContainerFactory
{
	/** @return RouteFormContainer */
	public function create();
}


class RouteFormContainer extends BaseFormContainer
{
    public function configure() 
	{
		$form = $this->getForm();
		
		$form->addText('route', _('Route'))
				->setRequired(_('Please enter route'));
    }


	public function setDefaultValues($object)
	{
		$form = $this->getForm();
		
		$form['route']->setDefaultValue($object->routerEntity->route);
	}

}