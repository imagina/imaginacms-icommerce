<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Repositories\CategoryRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{

    public function findBySlug($slug)
    {
        return $this->model->where('slug', "$slug")->firstOrFail();
    }

    public function findParentCategories()
    {
        return $this->model->with(['children'])->where('parent_id', 0)->orderBy('id', 'DESC')->paginate(8);
    }


    public function allcat()
    {
        return $this->model->orderBy('title', 'asc')->get();
    }


    public function all()
    {
        return $this->model
            ->where('parent_id', 0)
            ->orderBy('title', 'asc')
            ->whereNotIn('id', [333, 334, 335])
            ->paginate(12);
    }

    /**
     * @param object $filter
     * @return mixed
     */
    public function whereFilters($filter)
    {
        try {

            $query = $this->model->with('parent','children');
            if (isset($filter->parent)) {
                $query->where('parent_id', $filter->parent);
            }
            if (isset($filter->search)) {
                $criterion = $filter->search;
                $param = explode(' ', $criterion);
                $query->where(function ($query) use ($param) {
                    foreach ($param as $index => $word) {
                        if ($index == 0) {
                            $query->where('title', 'like', "%".$word."%");
                        } else {
                            $query->orWhere('title', 'like', "%".$word."%");
                        }
                    }

                });
            }
            if (isset($filter->order)) { //si hay que filtrar por rango de precio

                $orderby = $filter->order->by ?? 'created_at';
                $ordertype = $filter->order->type ?? 'desc';
            } else {
                $orderby = 'created_at';
                $ordertype = 'desc';
            }
            if (isset($filter->skip)) { //si hay que filtrar por rango de precio
                $query->skip($filter->skip ?? 0);
            }
            $query->orderBy($orderby, $ordertype);
            if (isset($filter->take)) {
                $query->take($filter->take ?? 5);
                return $query->get();
            } elseif (isset($filter->paginate) && is_integer($filter->paginate)) {
                return $query->paginate($filter->paginate);
            } else {
                return $query->paginate(12);
            }

        } catch (\Exception $e) {
            \Log::Error($e);
            return $e->getMessage();
        }
    }
}
