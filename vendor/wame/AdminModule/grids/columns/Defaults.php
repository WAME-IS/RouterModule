<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;

class Defaults extends BaseGridItem
{
	/** {@inheritDoc} */
	public function render($grid)
    {
		$grid->addColumnText('defaults', _('Defaults'))
                ->setRenderer(function($item) {
                    return json_encode($item->params);
                });
                
		return $grid;
	}
    
}