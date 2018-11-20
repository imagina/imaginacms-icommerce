<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\WishlistRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentWishlistRepository extends EloquentBaseRepository implements WishlistRepository
{
    public function whereUserId($id)
    {
        return $this->model
            ->leftJoin('icommerce__products', 'icommerce__products.id',
                '=', 'icommerce__wishlists.product_id')
            ->where('icommerce__wishlists.user_id', $id)
            ->orderBy('icommerce__wishlists.created_at', 'desc')
            ->get();
    }

    public function whereUserProduct($userID,$productID){
    	return $this->model
    	->where([['user_id', '=', $userID], ['product_id', '=', $productID]])
    	->first();

    }
}
