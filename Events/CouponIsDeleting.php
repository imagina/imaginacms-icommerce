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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->model;
    }

     /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return [];
    }
 
}
