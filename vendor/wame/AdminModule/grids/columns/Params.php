<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;

class Params extends BaseGridItem
{
	/** {@inheritDoc} */
	public function render($grid)
    {
		$grid->addColumnText('params', _('Params'))
                ->setRenderer(function($item) {
                    return json_encode($item->params);
                });
                
		return $grid;
	}
    
}