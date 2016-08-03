<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class ModuleGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('module', _('Module'))
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
}