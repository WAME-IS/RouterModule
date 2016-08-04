<?php

namespace Wame\RouterModule\Vendor\Wame\AdminModule\Grids\Columns;

use Wame\DataGridControl\BaseGridColumn;

class SitemapGridColumn extends BaseGridColumn
{
    private $grid;
    
    
	public function addColumn($grid)
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
	
	public function sitemapChange($id, $new_status)
	{
        if($this->grid->getDataSource() instanceof \Doctrine\ORM\QueryBuilder) {
            $query = $this->grid->getDataSource();
            
            $item = $query->andWhere("a.id = :id")
                    ->setParameter('id', $id)
                    ->getQuery()->getSingleResult();
            
            $item->status = $new_status;
            
            if ($this->grid->presenter->isAjax()) {
                $this->grid->redrawItem($id);
            }
        }
	}
    
}