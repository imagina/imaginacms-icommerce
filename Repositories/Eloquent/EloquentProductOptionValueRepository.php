<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\ProductOptionValue;
use Modules\Icommerce\Repositories\ProductOptionValueRepository;
//Events media
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;

class EloquentProductOptionValueRepository extends EloquentBaseRepository implements ProductOptionValueRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = []; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter

            // add filter by search
            if (isset($filter->search)) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->where('description', 'like', '%'.$filter->search.'%')
                      ->orWhere('id', 'like', '%'.$filter->search.'%')
                      ->orWhere('price', 'like', '%'.$filter->search.'%')
                      ->orWhere('quantity', 'like', '%'.$filter->search.'%')
                      ->orWhere('updated_at', 'like', '%'.$filter->search.'%')
                      ->orWhere('created_at', 'like', '%'.$filter->search.'%');
                });
            }

            /*== By Option ==*/
            if (isset($filter->option)) {
                $query->where('option_id', $filter->option);
            }

            /*== By Product ID ==*/
            if (isset($filter->productOptionId)) {
                $query->where('product_option_id', $filter->productOptionId);
            }

            /*== By parent Option Value ==*/
            if (isset($filter->parentOptionValue)) {
                $query->where('parent_option_value_id', $filter->parentOptionValue);
            }

            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date; //Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from)) {//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                }
                if (isset($date->to)) {//to a date
                    $query->whereDate($date->field, '<=', $date->to);
                }
            }

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at'; //Default field
                $orderWay = $filter->order->way ?? 'desc'; //Default way
                $query->orderBy($orderByField, $orderWay); //Add order to query
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false; //Take

            return $query->get();
        }
    }

    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = []; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field)) {//Filter by specific field
                $field = $filter->field;
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
    }

    public function create($data)
    {
        $productOptionValue = $this->model->create($data);

        //Event to ADD media
        event(new CreateMedia($productOptionValue, $data));

        if (! empty($productOptionValue->parent_prod_opt_val_id)) {
            $parent = ProductOptionValue::find($productOptionValue->parent_prod_opt_val_id);

            //Verificacion y posible actualizacion de status y stock de padre
            $parent->updateStockByChildren();
        }

        return $productOptionValue;
    }

    public function updateBy($criteria, $data, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            //Update by field
            if (isset($filter->field)) {
                $field = $filter->field;
            }
        }

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();

        if (! empty($model)) {
            event(new UpdateMedia($model, $data)); //Event to Update media
            $model->update((array) $data);

            if (! empty($model->parent_option_value_id)) {
                $parent = $model->parentProductOptionValue;
                //Verificacion y posible actualizacion de status y stock de padre
                $parent->updateStockByChildren();
            }
        }

        return $model;
    }

    public function deleteBy($criteria, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field)) {//Where field
                $field = $filter->field;
            }
        }

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();
        event(new DeleteMedia($model->id, get_class($model))); //Event to Delete media
        $model ? $model->delete() : false;
    }
}
