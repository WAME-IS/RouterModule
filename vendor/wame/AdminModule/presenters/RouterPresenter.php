<?php

namespace App\AdminModule\Presenters;

use Wame\RouterModule\Entities\RouterEntity;
use Wame\RouterModule\Repositories\RouterRepository;
use Wame\RouterModule\Vendor\Wame\AdminModule\Grids\RouterGrid;
use Wame\DataGridControl\IDataGridControlFactory;
use Wame\RouterModule\Vendor\Wame\AdminModule\Forms\RouterForm;

class RouterPresenter extends BasePresenter
{	
    /** @var RouterRepository @inject */
	public $routerRepository;
    
	/** @var RouterEntity */
	private $routerEntity;
    
    /** @var IDataGridControlFactory @inject */
	public $gridControl;
    
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
		
		$this->routerEntity = $this->entityManager->getRepository(RouterEntity::class);
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
//        
//        $this->flashMessage(
//            "Id: $item_id, Previous id: $prev_id, Next id: $next_id",
//            'success'
//        );
        
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
		$this->template->routerEntity = $this->routerEntity->findBy(['status' => RouterRepository::STATUS_ENABLED]);
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
    
    protected function createComponentRouterForm()
	{
        $form = $this->routerForm->setId($this->id)->build();
		
		return $form;
	}
    
    
    /**
	 * Create role grid component
	 * @param type $name
	 * @return type
	 */
	protected function createComponentRouterGrid()
	{
        $qb = $this->routerRepository->createQueryBuilder('a');
        $qb->andWhere($qb->expr()->isNull('a.parent'));
        
		$grid = $this->gridControl->create();
		$grid->setDataSource($qb);
		$grid->setProvider($this->routerGrid);
        $grid->setSortable();
        
        $grid->setTreeView([$this, 'getChildren'], 'children');
		
		return $grid;
	}
    
    public function getChildren($item)
    {
        $qb = $this->routerRepository->createQueryBuilder('a');
        $qb->andWhere($qb->expr()->eq('a.parent', ':parent'))->setParameter('parent', $item);
        
        return $qb;
    }

}
