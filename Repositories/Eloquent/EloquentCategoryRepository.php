<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{

	public function findBySlug($slug)
    {
        return $this->model->where('slug', "$slug")->firstOrFail();
    }

    public function findParentCategories() {
	    return $this->model->with(['children'])->where('parent_id', 0)->orderBy('id', 'DESC')->paginate(8);
    }


    public function allcat(){
        return $this->model->orderBy('title','asc')->get();
    }


    public function all(){
	    return $this->model
                    ->where('parent_id',0)
                    ->orderBy('title','asc')
                    ->whereNotIn('id', [333,334,335])
                    ->paginate(12);
    }

}
