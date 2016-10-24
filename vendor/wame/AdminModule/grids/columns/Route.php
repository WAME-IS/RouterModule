<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;

class Route extends BaseGridItem
{
	/** {@inheritDoc} */
	public function render($grid)
    {
		$grid->addColumnText('route', _('Route'))
                ->setEditableCallback([$this, 'columnEdited'])
                ->setSortable()
				->setFilterText();

		return $grid;
	}

    /**
     * Callback
     *
     * @param integer $id       ID
     * @param string $value     new value
     */
    public function columnEdited($id, $value)
    {
        echo("Id: $id, new value: $value"); die;
    }

}