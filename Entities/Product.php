<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Icommerce\Presenters\ProductPresenter;
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
        'sort_order'
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

    public function priceLists()
    {
        return $this->belongsToMany(PriceList::class, ProductList::class)
            ->withPivot('price')
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function taxClass()
    {
        return $this->belongsTo(TaxClass::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'icommerce__product_category')->withTimestamps();
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


    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }


    protected function setRatingAttribute($value)
    {

        if (!empty($value)) {
            $this->attributes['rating'] = $value;
        } else {
            $this->attributes['rating'] = 5;
        }

    }

    public function getDiscountAttribute()
    {
        $now = date('Y-m-d');

        $userId = Auth::user() ? Auth::user()->id : 0;
        $departments = [];
        if ($userId){
            $departments = \DB::connection(env('DB_CONNECTION', 'mysql'))
                ->table('iprofile__user_department')->select("department_id")
                ->where('user_id', $userId)
                ->pluck('department_id');

        }

        $discount = $this->discounts()
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc')
            ->whereRaw('quantity > quantity_sold')
            ->where('date_end', '>=', $now)
            ->where('date_start', '<=', $now)
            ->where(function ($query) use ($departments){
                $query->whereIn('department_id', $departments)
                    ->orWhereNull('department_id');
            })
            ->first();

        if(isset($discount->id)){
            return $discount;

        }else{
            return null;
        }
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
                'alt'=>$img->alt??null
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

        if($useOldRoutes)
            return \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.'.$this->category->slug.'.product', [$this->slug]);
        else
            return \URL::route(\LaravelLocalization::getCurrentLocale() .  '.icommerce.store.show',$this->slug);



    }

}
