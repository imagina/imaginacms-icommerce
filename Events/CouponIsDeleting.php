<?php

namespace Modules\Icommerce\Events;

class CouponIsDeleting
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Return the entity
     */
    public function getEntity()
    {
        return $this->model;
    }

    /**
     * Return the ALL data sent
     */
    public function getSubmissionData()
    {
        return [];
    }
}
