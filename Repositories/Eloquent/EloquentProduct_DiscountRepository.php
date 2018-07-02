<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\Product_DiscountRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentProduct_DiscountRepository extends EloquentBaseRepository implements Product_DiscountRepository
{

	public function findByProduct($productID){

		return $this->model->where("product_id",'=',$productID)->get();
	}

}
