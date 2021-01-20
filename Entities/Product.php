<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Icommerce\Presenters\ProductPresenter;
use Modules\Icurrency\Support\Facades\Currency;
use Modules\Ihelpers\Traits\Relationable;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;
use willvincent\Rateable\Rateable;
use Illuminate\Support\Facades\Auth;

class Product extends Model implements TaggableInterface
{
  use Translatable, NamespacedEntity, TaggableTrait, MediaRelation, PresentableTrait, Rateable, Relationable;
  
  protected $table = 'icommerce__products';
  protected static $entityNamespace = 'asgardcms/product';
  private $user;
  public $translatedAttributes = [
    'name',
    'description',
    'summary',
    'slug',
    'meta_title',
    'meta_description'
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
    'height',
    'subtract',
    'minimum',
    'reference',
    'rating',
    'freeshipping',
    'order_weight',
    'store_id',
    'featured',
    'sum_rating',
    'sort_order',
    'is_call'
  ];
  
  protected $presenter = ProductPresenter::class;
  protected $casts = [
    'options' => 'array'
  ];
  protected $width = ['files'];
  
  public function store()
  {
    if (is_module_enabled('Marketplace')) {
      return $this->belongsTo('Modules\Marketplace\Entities\Store');
    }
    return $this->belongsTo(Store::class);
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
    return $this->belongsTo(Category::class)->with('translations');
  }
  
  public function taxClass()
  {
    return $this->belongsTo(TaxClass::class);
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
  
  public function discounts()
  {
    return $this->hasMany(ProductDiscount::class);
  }
  
  public function productOptions()
  {
    return $this->belongsToMany(Option::class, 'icommerce__product_option')
      ->withPivot('id', 'parent_id', 'parent_option_value_id', 'value', 'required')
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
  
  public function wishlists()
  {
    return $this->hasMany(Wishlist::class);
  }
  
  public function coupons()
  {
    return $this->belongsToMany(Coupon::class, 'icommerce__coupon_product')->withTimestamps();
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
  
  public function comments()
  {
    return $this->hasMany(Comment::class);
  }
  
  public function carts()
  {
    return $this->hasMany(CartProduct::class);
  }
  
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
  
  
  protected function setRatingAttribute($value)
  {
    $defaultRating = config("asgard.icommerce.config.defaultProductRating");
    if (!empty($value)) {
      $this->attributes['rating'] = $defaultRating ?? $value;
    } else {
      $this->attributes['rating'] = 5;
    }
    
  }
  public function getAuthUserAttribute(){
    
    return Auth::user();
  }
  
  public function discount()
  {
  
  
    $user = $this->auth_user;
    $userId = $user->id ?? 0;
    $departments = [];
    if(!empty($userId)) {
      $departments = \DB::table('iprofile__user_department')
        ->where("user_id", $userId)
        ->get()
        ->pluck("department_id")->toArray();
    }
  
    // return one Discount
    return $this->hasOne(ProductDiscount::class)
      
      //where the discount belongs to the user department's
      //or where the department of the discount is Null - for all Users
      ->where(function ($query) use ($userId) {
        $query->whereIn('icommerce__product_discounts.department_id', function ($query) use ($userId) {
          $query->select("department_id")
            ->from('iprofile__user_department')
            ->where('user_id', $userId);
        })->orWhereNull('department_id');
      })
      
      //where the discount not belongs to the exclude departments
      //or where the exclude departments of the discount is Null - for all Users
      ->where(function ($query) use ($departments) {
        foreach ($departments as $departmentId) {
          $query->whereRaw("(" . $departmentId . " not in (REPLACE(REPLACE(REPLACE(exclude_departments, '\'', ''), '[', ''), ']', '')))");
        }
        $query->orWhere('exclude_departments', "[]");
        $query->orWhereNull('exclude_departments');
      })
      
      
      //where the discount  belongs to the include departments
      //or where the exclude departments of the discount is Null - for all Users
      ->where(function ($query) use ($departments) {
        foreach ($departments as $departmentId) {
          $query->whereRaw("(" . $departmentId . " in (REPLACE(REPLACE(REPLACE(include_departments, '\'', ''), '[', ''), ']', '')))");
        }
        $query->orWhere('include_departments', "[0]");
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
  
  
  public function getSecondaryImageAttribute()
  {
    $thumbnail = $this->files->where('zone', 'secondaryimage')->first();
    if (!$thumbnail) {
      $image = [
        'mimeType' => 'image/jpeg',
        'path' => url('modules/iblog/img/post/default.jpg')
      ];
    } else {
      $image = [
        'mimeType' => $thumbnail->mimetype,
        'path' => $thumbnail->path_string
      ];
    }
    return json_decode(json_encode($image));
  }
  
  public function getMainImageAttribute()
  {
    $thumbnail = $this->files->where('zone', 'mainimage')->first();
    
    if (!$thumbnail) {
      if (isset($this->options->mainimage)) {
        $image = [
          'mimeType' => 'image/jpeg',
          'path' => url($this->options->mainimage)
        ];
      } else {
        $image = [
          'mimeType' => 'image/jpeg',
          'path' => url('modules/iblog/img/post/default.jpg')
        ];
      }
    } else {
      $image = [
        'mimeType' => $thumbnail->mimetype,
        'path' => $thumbnail->path_string
      ];
    }
    return json_decode(json_encode($image));
    
  }
  
  public function getGalleryAttribute()
  {
    
    $gallery = $this->filesByZone('gallery')->get();
    $response = [];
    foreach ($gallery as $img) {
      array_push($response, [
        'mimeType' => $img->mimetype,
        'path' => $img->path_string,
        'alt' => $img->alt ?? null
      ]);
    }
    
    return json_decode(json_encode($response));
  }
  
  /**
   * URL product
   * @return string
   */
  public function getUrlAttribute()
  {
    
    $useOldRoutes = config('asgard.icommerce.config.useOldRoutes') ?? false;
    
    if ($useOldRoutes)
      return \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.' . $this->category->slug . '.product', [$this->slug]);
    else
      return \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.store.show', $this->slug);
    
    
  }
  
  /**
   * Is New product
   * @return number
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
  
  public function getPriceAttribute($value)
  {
    $price = $value;
    $auth = \Auth::user();
    
    $priceList = is_module_enabled('Icommercepricelist');
    $setting = json_decode(request()->get('setting'));
    
    if (isset($auth->id) && $priceList && !isset($setting->fromAdmin)) {
      if ($this->priceLists) {
        foreach ($this->priceLists as $pList) {
          if ($pList->related_entity == "Modules\Iprofile\Entities\Department") {
            if ($pList->related_id !== '0' && $pList->related_id !== 0) {
              $depts = $auth->departments()->where('department_id', $pList->related_id)->get();
              if ($auth && count($depts) > 0) {
                $price = $pList->pivot->price;
              }
            } else {
              $price = $pList->pivot->price;
            }
          } else {
            $price = $pList->pivot->price;
          }
        }//has priceLists
      }
    }
    return $price;
  }
  
}
