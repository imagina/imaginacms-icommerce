<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Discountable\Traits\DiscountableTrait;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;


class Category extends Model
{
    use Translatable, NamespacedEntity, MediaRelation, DiscountableTrait;

    protected $table = 'icommerce__categories';
    protected static $entityNamespace = 'asgardcms/icommerceCategory';
    public $translatedAttributes = [
        'title',
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
        'sort_order',
    ];



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


    public function store()
    {
        if (is_module_enabled('Marketplace')) {
            return $this->belongsTo('Modules\Marketplace\Entities\Store');
        }
        return $this->belongsTo(Store::class);
    }

    public function getUrlAttribute() {

        return \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.category.'.$this->slug);

    }

    public function getOptionsAttribute($value)
    {
        try {
            return json_decode(json_decode($value));
        } catch (\Exception $e) {
            return json_decode($value);
        }
    }

    public function getMainImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'mainimage')->first();
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

    public function getSecondaryImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'secondaryimage')->first();
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

  public function getTertiaryImageAttribute()
  {
    $thumbnail = $this->files()->where('zone', 'tertiaryimage')->first();
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
}
