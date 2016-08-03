<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class LangGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('lang', _('Lang'))
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
}