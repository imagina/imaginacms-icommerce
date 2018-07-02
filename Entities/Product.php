<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Bcrud\Support\Traits\CrudTrait;
use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\HasTranslations;
//use Modules\Media\Support\Traits\MediaRelation;

class Product extends Model
{
    use CrudTrait;
    use HasTranslations;
    //use MediaRelation;

    protected $table = 'icommerce__products';
    
    public $translatable = [
    'title','description','summary'
    ];

    protected $fillable = [
     'title',
      'slug',
      'description',
      'summary',
      'options',
      'status',
      'user_id',
      'category_id',
      'related_ids',
      'parent_id',
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
      'free_shipping'
    ];

    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array'
    ];

    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'icommerce__product_category')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'icommerce__product_tag')->withTimestamps();
    }

    public function order_products()
    {
        return $this->hasMany(Order_Product::class);
    }

    public function featured_products() {
        return $this->hasMany(Order_Product::class)->select('SUM(quantity) AS total_products')->groupBy('product_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class,'manufacturer_id');
    }

    public function product_discounts(){
    	return $this->hasMany(Product_Discount::class);
    }

    public function optionsv(){
    	return $this->belongsToMany(Option::class, 'icommerce__product_option')->withPivot('id','value', 'required')->withTimestamps()->using(Product_Option::class);
    }

    public function product_option_values(){
    	return $this->hasMany(Product_Option_Value::class);
    }
    
    public function orders(){
    	return $this->belongsToMany(Order::class, 'icommerce__order_product')->withPivot('title', 'reference','quantity','price','total','tax','reward')->withTimestamps()->using(Order_Product::class);
    }

    public function wishlists(){
    	return $this->hasMany(Wishlist::class);
    }
   
    public function coupons(){
    	return $this->belongsToMany(Coupon::class,'icommerce__coupon_product')->withTimestamps();
    }

    public function parent()
    {
        return $this->belongsTo('Modules\Icommerce\Entities\Product', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Icommerce\Entities\Product', 'parent_id');
    }

    public function comments()
    {
         return $this->hasMany(Comment::class);
    }

    protected function setSlugAttribute($value){
       
        if(!empty($value)){
            $this->attributes['slug'] = str_slug($value,'-');
        }else{
        	$this->attributes['slug'] = str_slug($this->title,'-');
        }

    }

    protected function setSummaryAttribute($value){

        if(!empty($value)){
            $this->attributes['summary'] = $value;
        } else {
            $this->attributes['summary'] = substr(strip_tags($this->description),0,150);
        }

    }

    protected function setQuantityAttribute($value){

        if(!empty($value)){
            $this->attributes['quantity'] = $value;
        } else {
            $this->attributes['quantity'] = 0;
        }

    }

    protected function setPriceAttribute($value){

        if(!empty($value)){
            $this->attributes['price'] = $value;
        } else {
            $this->attributes['price'] = 0;
        }

    }

    protected function setMinimumAttribute($value){

        if(!empty($value)){
            $this->attributes['minimum'] = $value;
        } else {
            $this->attributes['minimum'] = 1;
        }

    }

    protected function setSkuAttribute($value){

        if(!empty($value)){
            $this->attributes['sku'] = $value;
        } else {
            $this->attributes['sku'] = uniqid("s");
        }

    }

    public function getOptionsAttribute($value) {

        return json_decode(json_decode($value));
    }
    

    public function getUrlAttribute() {
        return url($this->slug);

    }

    protected function setRatingAttribute($value){

        empty($value) ? dd('vacio',$value)/*$this->attribute['rating'] = 3*/ : dd('vacio',$value) /*$this->attribute['rating'] = $value*/;

    }

    /* product discount return if discount is active */
    public function getDiscountAttribute(){
        $date = date_create(date("Y/m/d"));

        $query = $this->product_discounts()
                    ->select('price')
                    ->whereDate('date_start','<=',$date)
                    ->whereDate('date_end','>=',$date)
                    ->first();

        return $query ? $query->price : null;
    }

    public function getGalleryAttribute(){
        $images = \Storage::disk('publicmedia')->files('assets/icommerce/product/gallery/' . $this->id);
        return $images;
    }

    public function getRelatedIdsAttribute($value){

        if(!empty($value)){
            $ids = json_decode($value);
            $products_related = Product::whereIn("id",$ids)->take(20)->get();
            return $products_related;
        }

    }

}
