<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class DefaultsGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('defaults', _('Defaults'))
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
}