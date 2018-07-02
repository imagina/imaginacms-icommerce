<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\Order_ProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOrder_ProductRepository extends EloquentBaseRepository implements Order_ProductRepository
{

	public function findByOrderId($id)
    {
        return $this->model->where('order_id', $id)->get();
    }

    /**
     * Find featured products
     * @return mixed
     */
    public function whereFeaturedProducts() {
        return $this->model
            ->selectRaw('SUM(quantity) AS sale_product')
            ->groupBy('product_id')
            ->orderBy('sale_product', 'DESC')->get();
    }
}
