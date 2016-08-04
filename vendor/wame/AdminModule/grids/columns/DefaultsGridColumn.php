<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class DefaultsGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('defaults', _('Defaults'))
                ->setRenderer(function($item) {
                    return json_encode($item->params);
                });
                
		return $grid;
	}
    
}