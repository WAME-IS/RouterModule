<?php

namespace App\AdminModule\Presenters;

use Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters\AdminFormPresenter;
use Wame\RouterModule\Entities\RouterEntity;
use Wame\RouterModule\Repositories\RouterRepository;
use Wame\RouterModule\Vendor\Wame\AdminModule\Grids\RouterGrid;


class RouterPresenter extends AdminFormPresenter
{
    /** @var RouterRepository @inject */
	public $repository;

    /** @var RouterGrid @inject */
	public $routerGrid;

    /** @var RouterEntity */
	protected $entity;

    /** @var int */
	private $count;


    /** actions ***************************************************************/

    public function actionDefault()
    {
        if (!$this->user->isAllowed('router', 'default')) {
			$this->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
			$this->redirect(':Admin:Dashboad:');
		}

        $this->count = $this->repository->countBy([]);
    }


    public function actionEdit()
    {
        if (!$this->user->isAllowed('router', 'edit')) {
			$this->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
			$this->redirect(':Admin:Router:');
		}

        $this->entity = $this->repository->get(['id' => $this->id]);
    }


    public function actionDelete()
    {
        if (!$this->user->isAllowed('router', 'delete')) {
			$this->flashMessage(_('To enter this section you have not sufficient privileges.'), 'danger');
			$this->redirect(':Admin:Router:');
		}

        $this->entity = $this->repository->get(['id' => $this->id]);
    }


    /** handles ***************************************************************/

	public function handleDelete()
	{
        $this->repository->changeStatus(['id' => $this->id], RouterRepository::STATUS_DISABLED);

		$this->flashMessage(sprintf(_('Route for %s has been successfully deleted'), $this->entity->getPresenter() . ':' . $this->entity->getAction()), 'success');
		$this->redirect(':Admin:Router:', ['id' => null]);
	}


    /**
     * Handle sort
     *
     * @param integer $item_id      item id
     * @param integer $prev_id      prev id
     * @param integer $next_id      next id
     * @param integer $parent_id    parent id
     */
    public function handleSort($item_id, $prev_id, $next_id, $parent_id)
    {
        $item = $this->repository->get(['id' => $item_id]);
        $parent = $this->repository->get(['id' => $item_id]);

        $item->parent = $parent;

        // Todo
//        $item = $this->repository->get(['id' => $item_id]);
//        $this->repository->moveAfter($item, $prev_id);

        $this->flashMessage(
            "Id: $item_id, Previous id: $prev_id, Next id: $next_id, Parent id: $parent_id",
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
		$this->template->count = $this->count;
	}


    public function renderEdit()
    {
        $this->template->siteTitle = _('Edit route');
        $this->template->subTitle = $this->entity->getPresenter() . ':' . $this->entity->getAction();
    }


    public function renderDelete()
    {
        $this->template->siteTitle = _('Delete route');
        $this->template->subTitle = $this->entity->getPresenter() . ':' . $this->entity->getAction();
    }


    /** components ************************************************************/

	protected function createComponentRouterGrid()
	{
        $qb = $this->repository->createQueryBuilder('a');
        $qb->andWhere($qb->expr()->isNull('a.parent'));

		$this->routerGrid->setDataSource($qb);
        $this->routerGrid->setSortable();
        $this->routerGrid->setTreeView([$this, 'getChildren'], 'children');

		return $this->routerGrid;
	}


    public function getChildren($item)
    {
        $qb = $this->repository->createQueryBuilder('a');
        $qb->andWhere($qb->expr()->eq('a.parent', ':parent'))->setParameter('parent', $item);

        return $qb;
    }


    /** abstract methods ******************************************************/

    /** {@inheritdoc} */
    protected function getFormBuilderServiceAlias()
    {
        return 'Admin.RouteFormBuilder';
    }

}
