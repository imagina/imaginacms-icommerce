<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Str;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Manufacturer extends CrudModel
{
  use Translatable, NamespacedEntity, MediaRelation, BelongsToTenant;

  protected $table = 'icommerce__manufacturers';
  public $transformer = 'Modules\Icommerce\Transformers\ManufacturerTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ManufacturerRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateManufacturerRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateManufacturerRequest',
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
  public $translatedAttributes = [
    'name',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'translatable_options'
  ];
  protected $fillable = [
    'status',
    'options',
    'sort_order',
    'store_id'
  ];
  protected $casts = [
    'options' => 'array',
    'active' => 'boolean'
  ];

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  /*
  * Polimorphy Relations
  */
  public function coupons()
  {
    return $this->morphToMany(Coupon::class, 'couponable', 'icommerce__couponables');
  }

  public function getOptionsAttribute($value)
  {
    $response = json_decode($value);

    if(is_string($response)) {
      $response = json_decode($response);
    }

    return $response;
  }

  public function getUrlAttribute($locale = null)
  {
    $url = "";
    $currentLocale = $locale ?? locale();
    if (!is_null($locale)) {
      $this->slug = $this->getTranslation($locale)->slug;
    }

    if (empty($this->slug)) return "";

    if (!request()->wantsJson() || Str::startsWith(request()->path(), 'api')){

      $currentDomain = !empty($this->organization_id) ? tenant()->domain ?? tenancy()->find($this->organization_id)->domain :
        parse_url(config('app.url'), PHP_URL_HOST);

      if (config("app.url") != $currentDomain) {
        $savedDomain = config("app.url");
        config(["app.url" => "https://" . $currentDomain]);
      }

      $url = Str::replace(["{manufacturerSlug}"],[$this->slug], trans('icommerce::routes.store.index.manufacturer', [], $currentLocale));
      $url = \LaravelLocalization::localizeUrl('/' . $url, $currentLocale);

      if (isset($savedDomain) && !empty($savedDomain)) config(["app.url" => $savedDomain]);

    }
    return $url;
  }
}