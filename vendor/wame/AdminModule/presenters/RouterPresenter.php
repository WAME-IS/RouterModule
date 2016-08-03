<?php

namespace App\AdminModule\Presenters;

use Wame\RouterModule\Entities\RouterEntity;
use Wame\RouterModule\Repositories\RouterRepository;
use Wame\RouterModule\Vendor\Wame\AdminModule\Grids\RouterGrid;
use Wame\DataGridControl\IDataGridControlFactory;

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
    
    /**
	 * Create role grid component
	 * @param type $name
	 * @return type
	 */
	protected function createComponentRouterGrid()
	{
        $qb = $this->routerRepository->createQueryBuilder('a');
		$grid = $this->gridControl->create();
		$grid->setDataSource($qb);
		$grid->setProvider($this->routerGrid);
		
		return $grid;
	}

}
