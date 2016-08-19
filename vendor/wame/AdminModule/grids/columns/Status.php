<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

class Status extends \Wame\DataGridControl\Columns\Status
{
	/** {@inheritDoc} */
	public function render($grid)
    {
        $this->grid = $grid;
        
		$grid->addColumnStatus('status', _('Status'))
				->addOption(1, _('Enabled'))
					->setIcon('check')
					->setClass('btn-success')
					->endOption()
				->addOption(0, _('Disabled'))
					->setIcon('close')
					->setClass('btn-danger')
					->endOption()
				->onChange[] = [$this, 'statusChange'];
		
		return $grid;
	}
    
}