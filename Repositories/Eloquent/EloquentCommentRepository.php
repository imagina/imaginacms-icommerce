<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CommentRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCommentRepository extends EloquentBaseRepository implements CommentRepository
{

	public function countAll()
    {
        return $this->model->count();
    }

    public function whereProductId($id)
    {
        return $this->model->with(['user'])
            ->where('product_id', $id)
            ->orderBy('created_at', 'DESC')
            ->limit(3);

    }

}
