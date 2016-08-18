<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class RouteGridColumn extends BaseGridColumn
{
	public function addColumn($grid) {
		$grid->addColumnText('route', _('Route'))
                ->setEditableCallback([$this, 'columnEdited'])
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
    public function columnEdited($id, $value)
    {
        echo("Id: $id, new value: $value"); die;
    }
    
}