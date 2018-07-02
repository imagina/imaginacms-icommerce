<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Order_History extends Model
{
    
	use HasTranslations;
    protected $table = 'icommerce__order_histories';
   	
    public $translatable = [];

    protected $fillable = ['order_id','status','notify','comment'];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
