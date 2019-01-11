<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOptionRepository extends EloquentBaseRepository implements OptionRepository
{

	public function getAll(){
		return $this->model->with(['option_values'])->get();
	}

	/**
	* @param object $filter
	* @return mixed
	*/
	public function whereFilters($filter)
	{
		try {

			$query = $this->model;
			if (isset($filter->search)) {
				$criterion = $filter->search;
				$param = explode(' ', $criterion);
				$query->where(function ($query) use ($param) {
					foreach ($param as $index => $word) {
						if ($index == 0) {
							$query->where('description', 'like', "%".$word."%");
						} else {
							$query->orWhere('description', 'like', "%".$word."%");
						}
					}
				});
			}
			if (isset($filter->order)) {
				$orderby = $filter->order->by ?? 'created_at';
				$ordertype = $filter->order->type ?? 'desc';
			} else {
				$orderby = 'created_at';
				$ordertype = 'desc';
			}
			if (isset($filter->skip)) {
				$query->skip($filter->skip ?? 0);
			}
			$query->orderBy($orderby, $ordertype);
			if(isset($filter->category_id)){
				//Options of specific category
				$query->whereIn('icommerce__options.id', function($query) use($filter){
					$query->select('option_id')
						->from('icommerce__product_option')
						->whereIn('product_id',function($query) use($filter){
							$query->select('product_id')
								->from('icommerce__product_category')
								->where('category_id',$filter->category_id);
						});
				});
			}//category_id
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
	}//whereFilters($filter)

	public function findParentOptions()
	{
			return $this->model->with(['children'])->where('parent_id', 0)->orderBy('id', 'ASC')->paginate(15);
	}

	public function getChildrenOptions(){
		return $this->model->where('parent_id','!=', 0)->orderBy('id', 'ASC')->paginate(15);

	}

}
