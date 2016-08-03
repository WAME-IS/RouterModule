<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class ActionGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('action', _('Action'))
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
}