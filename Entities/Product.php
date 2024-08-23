<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Icommerce\Presenters\ProductPresenter;
use Modules\Icurrency\Support\Facades\Currency;
use Modules\Ihelpers\Traits\Relationable;
use Modules\Isite\Relations\EmptyRelation;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;
use Modules\Isite\Traits\Rateable;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Modules\Isite\Entities\Organization;
use Illuminate\Support\Str;
use Modules\Isite\Traits\Typeable;
use Modules\Core\Icrud\Traits\hasEventsWithBindings;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Isite\Traits\RevisionableTrait;
use Modules\Iqreable\Traits\IsQreable;

class Product extends CrudModel implements TaggableInterface
{
  use Translatable, NamespacedEntity, TaggableTrait, MediaRelation, PresentableTrait,
    Rateable, Relationable, BelongsToTenant, Typeable,
    IsQreable;

  protected $table = 'icommerce__products';
  public $transformer = 'Modules\Icommerce\Transformers\ProductTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ProductRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateProductRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateProductRequest',
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
    'description',
    'summary',
    'slug',
    'meta_title',
    'meta_description',
    'advanced_summary'
  ];
  protected $fillable = [
    'added_by_id',
    'options',
    'status',
    'category_id',
    'parent_id',
    'tax_class_id',
    'sku',
    'quantity',
    'stock_status',
    'manufacturer_id',
    'shipping',
    'price',
    'points',
    'date_available',
    'weight',
    'length',
    'width',
    'volume',
    'height',
    'subtract',
    'minimum',
    'reference',
    //'rating',
    'freeshipping',
    'order_weight',
    'store_id',
    'featured',
    'sum_rating',
    'sort_order',
    'is_call',
    'item_type_id',
    'entity_id',
    'entity_type',
    'custom_url',
    'external_id',
    'is_internal',
    'show_price_is_call',
    'weight_class_id',
    'length_class_id',
    'volume_class_id',
    'quantity_class_id',
  ];

  protected $presenter = ProductPresenter::class;
  protected $casts = [
    'options' => 'array'
  ];
  protected $width = ['files', 'tags', 'authPriceLists'];
  private $auth;


  public function __construct(array $attributes = [])
  {
    $this->auth = Auth::user();
    parent::__construct($attributes);
  }

  public function weightClass()
  {
    return $this->belongsTo(WeightClass::class);
  }

  public function volumeClass()
  {
    return $this->belongsTo(VolumeClass::class);
  }

  public function quantityClass()
  {
    return $this->belongsTo(QuantityClass::class);
  }


  public function lengthClass()
  {
    return $this->belongsTo(LengthClass::class);
  }

  public function entity()
  {

    return $this->belongsTo($this->entity_type, 'entity_id');

  }

  public function addedBy()
  {
    $driver = config('asgard.user.config.driver');

    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'added_by_id');
  }

  public function stockStatus()
  {
    $stockStatus = new StockStatus();
    return $stockStatus->get($this->stock_status);
  }

  public function category()
  {
    $this->tenantWithCentralData = config("asgard.icommerce.config.tenantWithCentralData.categories");

    if ($this->tenantWithCentralData)
      return $this->belongsTo(Category::class)->with('translations')->withoutTenancy();
    else
      return $this->belongsTo(Category::class)->with('translations');
  }

  public function taxClass()
  {
    return $this->belongsTo(TaxClass::class)->with('translations')->with('rates');
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class, 'icommerce__product_category')->withTimestamps()->with('translations');
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class, 'product_id');
  }

  public function manufacturer()
  {
    return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
  }


  public function itemType()
  {
    return $this->belongsTo(ItemType::class);
  }

  public function discounts()
  {
    return $this->hasMany(ProductDiscount::class);
  }

  public function optionsPivot()
  {

    return $this->hasMany(ProductOption::class);
  }

  public function productOptions()
  {

    return $this->belongsToMany(Option::class, 'icommerce__product_option')
      ->withPivot('id', 'parent_id', 'parent_option_value_id', 'value', 'required')
      ->withTimestamps();
  }

  /**
   * Warehouse Relation
   */
  public function productWarehouses()
  {

    return $this->belongsToMany(Warehouse::class, 'icommerce__product_warehouse')
      ->withPivot('id', 'product_id', 'warehouse_id', 'quantity')
      ->withTimestamps();
  }

  public function optionValues()
  {
    return $this->hasMany(ProductOptionValue::class);

  }

  public function relatedProducts()
  {
    return $this->belongsToMany(
      'Modules\Icommerce\Entities\Product',
      'icommerce__related_product',
      'product_id', 'related_id'
    )->withTimestamps();
  }

  public function orders()
  {
    return $this->belongsToMany(Order::class, 'icommerce__order_item')
      ->withPivot('title', 'reference', 'quantity', 'price', 'total', 'tax', 'reward')
      ->withTimestamps()
      ->using(OrderItem::class);
  }

  public function parent()
  {
    return $this->belongsTo('Modules\Icommerce\Entities\Product', 'parent_id');
  }

  public function children()
  {
    return $this->hasMany('Modules\Icommerce\Entities\Product', 'parent_id')
      ->orderBy('order_weight', 'desc')
      ->orderBy('created_at', 'desc');
  }


  public function carts()
  {
    return $this->hasMany(CartProduct::class);
  }


  /*
    * Polimorphy Relations
    */
  public function coupons()
  {
    return $this->morphToMany(Coupon::class, 'couponable', 'icommerce__couponables');
  }

  /*
    * Mutators / Accessors
    */
  protected function setQuantityAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['quantity'] = $value;
    } else {
      $this->attributes['quantity'] = 0;
    }

  }

  protected function setPriceAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['price'] = $value;
    } else {
      $this->attributes['price'] = 0;
    }

  }

  protected function setMinimumAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['minimum'] = $value;
    } else {
      $this->attributes['minimum'] = 1;
    }

  }

  protected function setSkuAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['sku'] = $value;
    } else {
      $this->attributes['sku'] = uniqid("s");
    }

  }


  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }


  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }


  public function discount()
  {
    $user = $this->auth;
    $userId = $user->id ?? 0;
    //dd($userId);
    $departments = [];
    if (!empty($userId)) {
      $departments = \DB::table('iprofile__user_department')
        ->where("user_id", $userId)
        ->get()
        ->pluck("department_id")->toArray();
    }

    // return one Discount
    return $this->hasOne(ProductDiscount::class)


      //where the discount not belongs to the exclude departments
      //or where the exclude departments of the discount is Null - for all Users
      ->where(function ($query) use ($departments) {
        foreach ($departments as $departmentId) {
          $query->whereRaw("(" . $departmentId . " not in (REPLACE(REPLACE(REPLACE(exclude_departments, '\'', ''), '[', ''), ']', '')))");
        }
        $query->orWhere('exclude_departments', "[]");
        $query->orWhereNull('exclude_departments');

        if (empty($departments)) {
          $query->orWhereRaw("(0 in (REPLACE(REPLACE(REPLACE(include_departments, '\"', ''), '[', ''), ']', '')))");
        }
      })


      //where the discount  belongs to the include departments
      //or where the exclude departments of the discount is Null - for all Users
      ->where(function ($query) use ($departments) {
        foreach ($departments as $departmentId) {
          $query->whereRaw("(" . $departmentId . " in (REPLACE(REPLACE(REPLACE(include_departments, '\'', ''), '[', ''), ']', '')))");
        }
        $query->orWhere('include_departments', '["0"]');
        $query->orWhere('include_departments', "[]");
        $query->orWhereNull('include_departments');
      })

      // ordered by priority
      ->orderBy('priority', 'desc')

      // ordered by created_at
      ->orderBy('created_at', 'asc')

      // where the quantity_sold be less than quantity available for the discount
      ->whereRaw('quantity_sold < icommerce__product_discounts.quantity')

      // where now is between date_end and date_start
      ->where('date_end', '>=', date('Y-m-d'))
      ->where('date_start', '<=', date('Y-m-d'));

  }

  public function organization()
  {
    return $this->belongsTo(Organization::class);
  }

  /**
   * URL product
   * @return string
   */
  public function getUrlAttribute($locale = null)
  {
    $url = "";

    if (!empty($this->custom_url)) return $this->custom_url;

    $useOldRoutes = config('asgard.icommerce.config.useOldRoutes') ?? false;

    $currentLocale = $locale ?? locale();
    if (!is_null($locale)) {
      $this->slug = $this->getTranslation($locale)->slug;
      $this->category = $this->category->getTranslation($locale);
    }

    if (empty($this->slug)) return "";

    if (!request()->wantsJson() || Str::startsWith(request()->path(), 'api')) {
      $host = request()->getHost();

      if ($useOldRoutes)
        if ($this->category->status && !empty($this->category->slug)) {
          $url = \LaravelLocalization::localizeUrl('/' . $this->category->slug . '/' . $this->slug, $currentLocale);
        } else {
          $url = "";
        }
      else {
        $tenancyMode = config("tenancy.mode", null);


        if (!empty($tenancyMode) && $tenancyMode == "singleDatabase" && !empty($this->organization_id)) {
          return tenant_route(Str::remove('https://', $this->organization->url), $currentLocale . '.icommerce.store.show', [$this->slug]);

        }

        $url = Str::replace(["{productSlug}"], [$this->slug], trans('icommerce::routes.store.show.product', [], $currentLocale));
        $url = \LaravelLocalization::localizeUrl('/' . $url, $currentLocale);

      }
    }

    return $url;
  }

  /**
   * Is New product
   * @return boolean
   */
  public function getIsNewAttribute()
  {
    $isNew = false;
    $daysEnabledForNewProducts = setting('icommerce::daysEnabledForNewProducts');
    $date1 = new \DateTime($this->created_at);
    $date2 = new \DateTime(now());
    $days = $date2->diff($date1)->format('%a');
    if ($days <= $daysEnabledForNewProducts) {
      $isNew = true;
    }

    return $isNew;
  }

  /**
   * Is Sold Out
   * @return boolean
   */
  public function getIsSoldOutAttribute()
  {

    return ($this->quantity <= 0 && $this->subtract) || (!$this->stock_status);

  }


  /**
   * Is New product
   * @return number
   */
  public function getIsAvailableAttribute()
  {
    $isAvailable = false;

    $availableDate = new \DateTime($this->date_available);
    $now = new \DateTime(date('Y-m-d'));


    if ($this->status) {
      if ($now >= $availableDate) { // if the date is available
        if ($this->stock_status) { // if it's in stock
          if (($this->subtract && $this->quantity) || !$this->subtract) { //if its subtrack of stock and has quantity or isn't subtrack
            $isAvailable = true;
          }
        }
      }
    }

    return $isAvailable;
  }

  public function getPriceByListAttribute()
  {
    $price = null;
    $auth = $this->auth;

    $priceList = is_module_enabled('Icommercepricelist');
    $setting = json_decode(request()->get('setting'));

    if (isset($auth->id) && $priceList && (!isset($setting->fromAdmin) || !$setting->fromAdmin)) {
      $priceList = $this->authPriceLists->where('related_id', '!=', 0)->first() ?? $this->authPriceLists->first();

      if ($priceList) {
        if ($priceList->criteria === 'percentage') {
          //Calculate percentage
          $price = icommercepricelist_calculatePriceByPriceList($priceList, $this->getRawOriginal('price'));
        } else {
          //Get value of fixed
          $price = $priceList->pivot->price;
        }
      }
    }
    return $price;
  }

  public function priceLists()
  {
    if (is_module_enabled('Icommercepricelist')) {
      return $this->belongsToMany(\Modules\Icommercepricelist\Entities\PriceList::class, \Modules\Icommercepricelist\Entities\ProductList::class)
        ->withPivot(['price', 'id'])
        ->withTimestamps();
    }
    return new EmptyRelation();
  }

  public function authPriceLists()
  {
    $user = $this->auth;
    //Verify if exist module and the user
    if (is_module_enabled('Icommercepricelist') && $user) {
      //Get the priceList with the pivot
      return $this->belongsToMany(\Modules\Icommercepricelist\Entities\PriceList::class, \Modules\Icommercepricelist\Entities\ProductList::class)
        ->withPivot(['price', 'id'])
        ->withTimestamps()
        ->where('related_entity', 'Modules\\Iprofile\\Entities\\Department')
        ->where(function ($query) use ($user) {
          $query->whereNull('related_id')
            ->orWhere('related_id', 0)
            ->orWhereIn('related_id', function ($q) use ($user) {
              $q->select('department_id')->from('iprofile__user_department')->where('user_id', $user->id);
            });
        })->orderBy('created_at', 'desc');//Order by newest data
    }

    return new EmptyRelation();
  }

  public function tax($couponDiscount = 0)
  {

    $taxes = [];
    $rates = $this->taxClass->rates ?? [];

    foreach ($rates as $rate) {

      array_push($taxes, [
        "rateId" => $rate->id,
        "productId" => $this->id,
        "tax" => $rate->calcTax(($this->discount->price ?? $this->price) - $couponDiscount),
        "rateName" => $rate->name,
        "rate" => $rate->rate,
        "rateType" => $rate->type,
      ]);

    }

    return $taxes;
  }

  // Mutator to return the product price in order of, priceList or product price
  // IMPORTANT: if you need to get the price base for any calculation use $this->getRawOriginal('price')
  // This will prevent to call this mutator and not generate an infinity loop
  public function getPriceAttribute($value)
  {
    return $this->priceByList ?? $value;
  }
}
