<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ProductDiscountRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentProductDiscountRepository extends EloquentBaseRepository implements ProductDiscountRepository
{
    public function getItemsBy($params)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();

        // RELATIONSHIPS
        $defaultInclude = [];
        $query->with(array_merge($defaultInclude, $params->include));

        // FILTERS
        if ($params->filter) {
            $filter = $params->filter;

            //get language translation
            $lang = \App::getLocale();

            //add filter by search
            if (isset($filter->search)) {
                //find search in columns
                $query->where('id', 'like', '%' . $filter->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
                    ->orWhere('created_at', 'like', '%' . $filter->search . '%');
            }

            /*== By product ==*/
            if (isset($filter->productId))
                $query->where('product_id', $filter->productId);

            if (isset($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
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

    public function getItem($criteria, $params = false)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();

        $query->where('id', $criteria);

        // RELATIONSHIPS
        $includeDefault = [];
        $query->with(array_merge($includeDefault, $params->include));


        // FIELDS
        if ($params->fields) {
            $query->select($params->fields);
        }
        return $query->first();

    }

    public function create($data)
    {

        $productList = $this->model->create($data);

        return $productList;
    }

    public function updateBy($criteria, $data, $params = false){

        // INITIALIZE QUERY
        $query = $this->model->query();

        // FILTER
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Where field
                $query->where($filter->field, $criteria);
            else//where id
                $query->where('id', $criteria);
        }

        // REQUEST
        $model = $query->first();

        if($model) {
            $model->update($data);
        }
        return $model;
    }

    public function deleteBy($criteria, $params = false)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();

        // FILTER
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field)) //Where field
                $query->where($filter->field, $criteria);
            else //where id
                $query->where('id', $criteria);
        }

        // REQUEST
        $model = $query->first();

        if($model) {
            $model->delete();
        }
    }
}
