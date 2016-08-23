<?php

namespace App\AdminModule\Presenters;

use Wame\RouterModule\Entities\RouterEntity;
use Wame\RouterModule\Repositories\RouterRepository;
use Wame\RouterModule\Vendor\Wame\AdminModule\Grids\RouterGrid;
use Wame\RouterModule\Vendor\Wame\AdminModule\Forms\RouterForm;

class RouterPresenter extends BasePresenter
{	
    /** @var RouterRepository @inject */
	public $routerRepository;
    
    /** @var RouterGrid @inject */
	public $routerGrid;
    
    /** @var RouterForm @inject */
	public $routerForm;
    
    
	public function startup() 
	{
		parent::startup();
		
		if (!$this->user->isAllowed('router', 'view')) {
			$this->flashMessage(_('To enter this section you have sufficient privileges.'), 'danger');
			$this->redirect('parent');
		}
	}
    
    
    /** actions ***************************************************************/
    
    
    public function actionEdit()
    {
        
    }
    
    public function actionCreate()
    {
        
    }
    
    
    /** handles ***************************************************************/
    
    public function handleDelete()
    {
        
    }
    
    public function handleSort($item_id, $prev_id, $next_id)
    {
//        $item = $this->routerRepository->get(['id' => $item_id]);
//        $this->routerRepository->moveAfter($item, $prev_id);
        
        $this->flashMessage(
            "Id: $item_id, Previous id: $prev_id, Next id: $next_id",
            'success'
        );
        
        if ($this->isAjax()) {
            $this->redrawControl('flashes');
        } else {
            $this->redirect('this');
        }
    }
    
    
    
    /** renders ***************************************************************/

	public function renderDefault()
	{
		$this->template->siteTitle = _('Routes');
		$this->template->routerEntity = $this->routerRepository->find();
	}
    
    public function renderEdit()
    {
        
    }
    
    public function renderCreate()
    {
        
    }
    
    public function renderDelete()
    {
        
    }
    
    
    /** components ************************************************************/
    
    /**
     * Router form component
     * 
     * @return RouterForm
     */
    protected function createComponentRouterForm()
	{
        $form = $this->routerForm->setId($this->id)->build();
		
		return $form;
	}
    
    
    /**
	 * Create router grid component
     * 
	 * @return RouterGrid
	 */
	protected function createComponentRouterGrid()
	{
        $qb = $this->routerRepository->createQueryBuilder('a');
        $qb->andWhere($qb->expr()->isNull('a.parent'));
        
		$this->routerGrid->setDataSource($qb);
        $this->routerGrid->setSortable();
        $this->routerGrid->setTreeView([$this, 'getChildren'], 'children');
		
		return $this->routerGrid;
	}
    
    public function getChildren($item)
    {
        $qb = $this->routerRepository->createQueryBuilder('a');
        $qb->andWhere($qb->expr()->eq('a.parent', ':parent'))->setParameter('parent', $item);
        
        return $qb;
    }

}
