<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridItem;

class Sitemap extends BaseGridItem
{
    /** @var DataGridControl */
    private $grid;
    
    
	/** {@inheritDoc} */
	public function render($grid)
    {
        $this->grid = $grid;
        
		$grid->addColumnStatus('sitemap', _('Sitemap'))
				->addOption(1, _('Yes'))
					->setIcon('check')
					->setClass('btn-success')
					->endOption()
				->addOption(0, _('No'))
					->setIcon('close')
					->setClass('btn-danger')
					->endOption()
				->onChange[] = [$this, 'sitemapChange'];
		
		return $grid;
	}
	
    /**
     * Callback
     * 
     * @param integer $id           ID
     * @param integer $newStatus    new status
     */
	public function sitemapChange($id, $newStatus)
	{
        if($this->grid->getDataSource() instanceof \Doctrine\ORM\QueryBuilder) {
            $query = $this->grid->getDataSource();
            
            $item = $query->andWhere("a.id = :id")
                    ->setParameter('id', $id)
                    ->getQuery()->getSingleResult();
            
            $item->status = $newStatus;
            
            if ($this->grid->presenter->isAjax()) {
                $this->grid->redrawItem($id);
            }
        }
	}
    
}