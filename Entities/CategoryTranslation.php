<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'title',
      'slug',
      'description',
      'meta_title',
      'meta_description'
    ];
    protected $table = 'icommerce__category_translations';
  
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
