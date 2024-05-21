<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class OptionValue extends CrudModel
{
  use Translatable, NamespacedEntity, MediaRelation, BelongsToTenant;

  protected $table = 'icommerce__option_values';
  public $transformer = 'Modules\Icommerce\Transformers\OptionValueTransformer';
  public $repository = 'Modules\Icommerce\Repositories\OptionValueRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateOptionValueRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateOptionValueRequest',
  ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  public $translatedAttributes = ['description'];
  protected $fillable = [
    'option_id',
    'sort_order',
    'options'
  ];


    protected $casts = [
        'options' => 'array',
    ];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function getOptionsAttribute($value)
    {
        try {
            $response = json_decode($value);
        } catch (\Exception $e) {
            $response = json_decode($value);
        }

        return $response ? $response : (object) [];
    }

    public function optionValues()
    {
        return $this->belongsToMany(Product::class, 'icommerce__product_option_value')
          ->withPivot(
              'id', 'product_option_id', 'option_id',
              'parent_option_value_id', 'quantity',
              'subtract', 'price', 'weight'
          )->withTimestamps();
    }

  public function productOptionValues()
  {
    return $this->belongsToMany(Product::class, 'icommerce__product_option_value')
      ->withPivot(
        'id', 'product_option_id', 'option_id',
        'parent_option_value_id', 'quantity',
        'subtract', 'price', 'weight'
      )->withTimestamps();
  }
}
