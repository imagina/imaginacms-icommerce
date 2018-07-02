<?php



namespace Modules\Icommerce\Entities;



use Illuminate\Database\Eloquent\Model;



//use Spatie\Translatable\HasTranslations;

use Modules\Bcrud\Support\Traits\CrudTrait;



//use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\Sluggable;

//use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\SluggableScopeHelpers;

use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\HasTranslations;



class Tag extends Model

{



    use CrudTrait;

    //use Sluggable, SluggableScopeHelpers;

    use HasTranslations;



    protected $table = 'icommerce__tags';



    public $translatable = ['title','slug'];



    protected $fillable = ['title','slug'];



    public function products()

    {

        return $this->belongsToMany(Product::class, 'icommerce__product_tag')->withTimestamps();

    }



    protected function setSlugAttribute($value){

        if(!empty($value)){

            $this->attributes['slug'] = str_slug($value,'-');

        }else{

            $this->attributes['slug'] = str_slug($this->title,'-');

        }

    }



    /*

    public function sluggable()

    {

        return [

            'slug' => [

                'source' => 'slug_or_name',

            ],

        ];

    }
    */

   

    /*

    public function getUrlAttribute() {

        return \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.tag.slug', [$this->slug]);

    }

    */



}