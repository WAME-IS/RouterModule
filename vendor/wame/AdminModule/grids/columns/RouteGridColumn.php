<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class RouteGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('route', _('Route'))
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
}