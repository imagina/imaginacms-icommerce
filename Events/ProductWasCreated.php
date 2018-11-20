<?php

namespace Modules\Icommerce\Events;

use Modules\Media\Contracts\StoringMedia;
use Modules\Icommerce\Entities\Product;

class ProductWasCreated implements StoringMedia
{

    public $data;
    public $product;


    public function __construct(Product $product, array $data)
    {
        $this->data = $data;
        $this->product = $product;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->product;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }

}
