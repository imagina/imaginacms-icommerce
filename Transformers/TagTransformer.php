<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class TagTransformer extends Resource
{
  public function toArray($request)
  {
    return  [
      'id' => $this->id,
      'title' => $this->title,
      'slug' => $this->slug,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}