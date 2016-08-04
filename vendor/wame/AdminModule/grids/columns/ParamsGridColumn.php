<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class ParamsGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('params', _('Params'))
                ->setRenderer(function($item) {
                    return json_encode($item->params);
                });
                
		return $grid;
	}
    
}