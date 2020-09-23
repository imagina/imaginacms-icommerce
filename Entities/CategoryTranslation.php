<?php

namespace Modules\Icommerce\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;


class CategoryTranslation extends Model
{
    use Sluggable;
    public $timestamps = false;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'translatable_options'
    ];
    protected $table = 'icommerce__category_translations';
    protected $casts = [
        'translatable_options' => 'array'
    ];
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function setMetaDescriptionAttribute($value){

        if(empty($value)){
            $this->attributes['meta_description'] = substr(strip_tags($this->description??''),0,150);
        }else{
            $this->attributes['meta_description'] = $value;
        }
    }
  
  public function getMetaDescriptionAttribute(){
    
    return $this->meta_description ?? substr(strip_tags($this->description??''),0,150);
  }
  
    public function getTranslatableOptionAttribute($value) {

        $options=json_decode($value);
        return $options;


    }
  
  
  /**
   * @return mixed
   */
  public function getMetaTitleAttribute(){
    
    return $this->meta_title ?? $this->title;
  }

  
  /**
     * @return mixed
     */
    public function setMetaTitleAttribute($value){

        if(empty($value)){
            $this->attributes['meta_title'] = $this->title??'';
        }else{
            $this->attributes['meta_title'] = $value;
        }
    }

}
