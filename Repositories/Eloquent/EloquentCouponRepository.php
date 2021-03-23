<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Repositories\CouponRepository;

class EloquentCouponRepository extends EloquentBaseRepository implements CouponRepository
{
    public function getItemsBy($params)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();

        // RELATIONSHIPS
        $defaultInclude = [];
        $query->with(array_merge($defaultInclude, $params->include ?? []));

        // FILTERS
        if ($params->filter) {
            $filter = $params->filter;

            //get language translation
            $lang = \App::getLocale();

            //add filter by search
            if (isset($filter->search)) {

                //find search in columns
                $query->where(function ($query) use ($filter, $lang) {
                    $query->whereHas('translations', function ($query) use ($filter, $lang) {
                        $query->where('locale', $lang)
                            ->where('name', 'like', '%' . $filter->search . '%');
                    })->orWhere('id', 'like', '%' . $filter->search . '%')
                        ->orWhere('code', 'like', '%' . $filter->search . '%')
                        ->orWhere('type', 'like', '%' . $filter->search . '%');
                });
            }
            if (isset($filter->store)) {
                $query->where('store_id', $filter->store);
            }
            //add filter by status
            if (!empty($filter->status)) {
                $query->where('status', $filter->status);
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
        }
    }

    public function getItem($criteria, $params)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
            $query->with(['store','product','category','customer','orders','couponHistories']);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include ?? []);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Filter by specific field
                $field = $filter->field;


            // find by specific attribute or by id
            $query->where($field ?? 'id', $criteria);
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->first();

    }


}
