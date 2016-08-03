<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class PresenterGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('presenter', _('Presenter'))
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
}