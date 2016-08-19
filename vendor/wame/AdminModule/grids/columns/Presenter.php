<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;

class Presenter extends BaseGridItem
{
	/** {@inheritDoc} */
	public function render($grid)
    {
		$grid->addColumnText('presenter', _('Presenter'))
                ->setSortable()
				->setFilterText();
                
		return $grid;
	}
    
}