<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOptionRepository extends EloquentBaseRepository implements OptionRepository
{

	public function getAll(){
		return $this->model->with(['option_values'])->get();
	}

}
