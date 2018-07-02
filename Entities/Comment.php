<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Bcrud\Support\Traits\CrudTrait;

class Comment extends Model
{
    use CrudTrait;

    protected $table = 'icommerce__comments';
    public $translatable = [];

    protected $fillable = [
      'content',
      'status',
      'user_id',
      'product_id'
    ];

    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }


}