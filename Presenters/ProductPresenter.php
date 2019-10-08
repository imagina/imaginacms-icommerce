<?php

namespace Modules\Icommerce\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Icommerce\Entities\OrderItem;
use Modules\Icommerce\Entities\Status;

class ProductPresenter extends Presenter
{
    /**
     * @var \Modules\Icommerce\Entities\Status
     */
    protected $status;
    /**
     * @var \Modules\Icommerce\Repositories\ProductRepository
     */
    private $post;

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->post = app('Modules\Icommerce\Repositories\ProductRepository');
        $this->status = app('Modules\Icommerce\Entities\Status');
    }

    /**
     * Get the post status
     * @return string
     */
    public function status()
    {
        return $this->status->get($this->entity->status);
    }

    /**
     * Getting the label class for the appropriate status
     * @return string
     */
    public function statusLabelClass()
    {
        switch ($this->entity->status) {
            case Status::DISABLED:
                return 'red';
                break;
            case Status::ENABLED:
                return 'green';
                break;
            default:
                return 'red';
                break;
        }
    }

}
