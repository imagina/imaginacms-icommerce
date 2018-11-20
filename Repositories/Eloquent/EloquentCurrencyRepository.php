<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\Status;

class EloquentCurrencyRepository extends EloquentBaseRepository implements CurrencyRepository
{

	 public function getActive(){

	 	return $this->model->whereStatus(Status::ENABLED)->first();

	 }

}
