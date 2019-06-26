<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'name',
      'description',
      'summary',
      'slug',
      'meta_title',
      'meta_description'
    ];
    protected $table = 'icommerce__product_translations';
  
  protected function setSlugAttribute($value){
    
    if($this->parent_id==0){
      if(!empty($value)){
        $this->attributes['slug'] = str_slug($value,'-');
      }else{
        $this->attributes['slug'] = str_slug($this->title,'-');
      }
    }else{
      $this->attributes['slug'] = $this->parent->slug.'/'.str_slug($this->title,'-');
    }
    
    
  }
}
