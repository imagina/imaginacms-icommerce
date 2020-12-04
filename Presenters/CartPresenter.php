<?php

namespace Modules\Icommerce\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Icommerce\Entities\CartStatus;


class CartPresenter extends Presenter
{
    /**
     * @var \Modules\Icommerce\Entities\CartStatus
     */
    protected $status;


    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->status = app('Modules\Icommerce\Entities\CartStatus');
    }

    public function total()
    {
        return $this->sum('subtotal');
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
            case CartStatus::ABANDONED:
                return 'bg-red';
                break;
            case CartStatus::ACTIVE:
                return 'bg-orange';
                break;
            case CartStatus::PROCESSED:
                return 'bg-green';
                break;
            default:
                return 'bg-red';
                break;
        }
    }

}
