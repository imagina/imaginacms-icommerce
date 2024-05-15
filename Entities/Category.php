<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Icrud\Traits\hasEventsWithBindings;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Isite\Entities\Organization;
use Modules\Isite\Traits\RevisionableTrait;
use Modules\Isite\Traits\Typeable;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Category extends CrudModel
{
  use Translatable, NamespacedEntity, MediaRelation, NodeTrait, BelongsToTenant,
     Typeable;

  protected $table = 'icommerce__categories';
  public $transformer = 'Modules\Icommerce\Transformers\CategoryTransformer';
  public $repository = 'Modules\Icommerce\Repositories\CategoryRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateCategoryRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateCategoryRequest',
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
    'title',
    'h1_title',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'translatable_options'
  ];
  protected $fillable = [
    'parent_id',
    'options',
    'show_menu',
    'featured',
    'store_id',
    'status',
    'sort_order',
    'external_id',
  ];

  protected $width = ['files', 'translations'];

  protected $casts = [
    'options' => 'array'
  ];


  public function parent()
  {
    return $this->belongsTo(Category::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(Category::class, 'parent_id');
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, 'icommerce__product_category')->withTimestamps();
  }

  /*
   * Own Products
   * Just used in Icommercepricelist module to create the list price by category
   * */
  public function ownProducts()
  {
    return $this->hasMany(Product::class)->where(function ($query) {
      $query->where("date_available", "<=", date("Y-m-d", strtotime(now())));
      $query->orWhereNull("date_available");
    })->where("status", 1)
      ->whereRaw("((subtract = 1 and quantity > 0) or (subtract = 0) or (stock_status = 0))");
  }

  public function manufacturers()
  {
    return $this->belongsToMany(Manufacturer::class, 'icommerce__products')->withTimestamps();
  }
  /*
* Polimorphy Relations
*/
  public function coupons()
  {
    return $this->morphToMany(Coupon::class, 'couponable', 'icommerce__couponables');
  }

  public function organization()
  {
    return $this->belongsTo(Organization::class);
  }

  /*
 * Mutators / Accessors
 */
  public function getUrlAttribute($locale = null)
  {
    $url = "";
    $useOldRoutes = config('asgard.icommerce.config.useOldRoutes') ?? false;

    $currentLocale = $locale ?? locale();
    if (!is_null($locale)) {
      $this->slug = $this->getTranslation($locale)->slug;
    }

    if (empty($this->slug)) return "";

    $routeName = request()->route()->getName();

    $currentDomain = !empty($this->organization_id) ? tenant()->domain ?? tenancy()->find($this->organization_id)->domain :
      parse_url(config('app.url'), PHP_URL_HOST);

    if (config("app.url") != $currentDomain) {
      $savedDomain = config("app.url");
      config(["app.url" => "https://" . $currentDomain]);
    }

    if (!request()->wantsJson() || Str::startsWith(request()->path(), 'api')) {
      if ($useOldRoutes) {
        $url = \LaravelLocalization::localizeUrl('/' . $this->slug, $currentLocale);
      } else {
        switch ($routeName) {

          case locale() . ".icommerce.store.index.categoryManufacturer":
          case locale() . ".icommerce.store.index.manufacturer":
            $manufacturerSlug = explode("/", request()->path());
            if($routeName == locale() . ".icommerce.store.index.categoryManufacturer"){
              $manufacturerSlug = $manufacturerSlug[0] == locale() ? $manufacturerSlug[5] : $manufacturerSlug[4];
            }else{
              $manufacturerSlug = $manufacturerSlug[0] == locale() ? $manufacturerSlug[3] : $manufacturerSlug[2];

            }

            if (!is_null($locale)) {
              $manufacturer = Manufacturer::whereTranslation("slug", $manufacturerSlug, locale())->first();
              $manufacturerSlug = $manufacturer->getTranslation($currentLocale)->slug ?? null;
              if (empty($manufacturerSlug)) return "";
            }

            $url = Str::replace(["{categorySlug}", "{manufacturerSlug}"], [$this->slug, $manufacturerSlug], trans('icommerce::routes.store.index.categoryManufacturer', [], $currentLocale));
            $url = \LaravelLocalization::localizeUrl('/' . $url, $currentLocale);
            break;

          default:
            $url = Str::replace(["{categorySlug}"], [$this->slug], trans('icommerce::routes.store.index.category', [], $currentLocale));
            $url = \LaravelLocalization::localizeUrl('/' . $url, $currentLocale);

            $tenancyMode = config("tenancy.mode", null);

            if (!empty($tenancyMode) && $tenancyMode == "singleDatabase" && !empty($this->organization_id)) {
              $url = tenant_route(Str::remove('https://', $this->organization->url), $currentLocale . '.icommerce.store.index.category', [$this->slug]);

            }
            break;
        }
      }
    }


    if (isset($savedDomain) && !empty($savedDomain)) config(["app.url" => $savedDomain]);

    return $url;
  }

  public function urlManufacturer(Manufacturer $manufacturer)
  {
    $url = "";
    $useOldRoutes = config('asgard.icommerce.config.useOldRoutes') ?? false;
    if (!(request()->wantsJson() || Str::startsWith(request()->path(), 'api'))) {
      $url = \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.store.index.categoryManufacturer', [$this->slug, $manufacturer->slug]);
    }
    return $url;
  }

  public function getOptionsAttribute($value)
  {
    try {
      return json_decode($value);
    } catch (\Exception $e) {
      return json_decode($value);
    }
  }

  public function getLftName()
  {
    return 'lft';
  }

  public function getRgtName()
  {
    return 'rgt';
  }

  public function getDepthName()
  {
    return 'depth';
  }

  public function getParentIdName()
  {
    return 'parent_id';
  }

  // Specify parent id attribute mutator
  public function setParentAttribute($value)
  {
    $this->setParentIdAttribute($value);
  }
}
