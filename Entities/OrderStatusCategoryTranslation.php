<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderStatusCategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'title'
    ];
    protected $table = 'icommerce__order_status_category_translations';
}
