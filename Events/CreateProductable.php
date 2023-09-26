<?php

namespace Modules\Icommerce\Events;

class CreateProductable
{
    public $model;

    public $data;

    public function __construct($model, array $data)
    {
        $this->model = $model;
        $this->data = $data;
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
        return $this->data;
    }
}
