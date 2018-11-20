<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Payment extends Model
{
   	use HasTranslations;

    protected $table = 'icommerce__payments';
    public $translatable = [];

    protected $fillable = ['order_id','name','amount','status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
