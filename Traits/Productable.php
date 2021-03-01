<?php


namespace Modules\Icommerce\Traits;

trait Productable
{

    /**
     * Make the Productable morph relation
     * @return object
     */
    public function product()
    {
        return $this->morphOne(get_class($this), 'productable', 'icommerce__productable')->withTimestamps()->orderBy('id');
    }
}
