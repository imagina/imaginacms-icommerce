<?php

namespace Modules\Icommerce\Entities;



class OptionType
{
  const CHECKBOX = "checkbox";
  const RADIO = "radio";
  const SELECT = "select";
  const TEXT = "text";
  const TEXTAREA = "textarea";
  const DATE = "date";
  const FILE = "file";


  private $types;

  public function __construct()
  {
    $this->types = [
      self::CHECKBOX => ['title' => trans('icommerce::options.types.checkbox'), 'dynamic' => 0],
      self::RADIO => ['title' => trans('icommerce::options.types.radio'), 'dynamic' => 0],
      self::SELECT => ['title' => trans('icommerce::options.types.select'), 'dynamic' => 0],
      self::TEXT => ['title' => trans('icommerce::options.types.text'), 'dynamic' => 1],
      self::TEXTAREA => ['title' => trans('icommerce::options.types.textarea'), 'dynamic' => 1]
      //self::DATE => ['title' => trans('icommerce::options.types.date'), 'dynamic' => 1],
      //self::FILE => ['title' => trans('icommerce::options.types.file'), 'dynamic' => 1]
    ];
  }

  public function lists()
  {
    return $this->types;
  }

  public function getAllTypes()
  {

    $types = $this->types;
    $typeTransform = [];
    foreach ($types as $key => $type) {
      array_push($typeTransform,['value' => $key, 'name' => $type]);
    }
    return collect($typeTransform);

  }

  /**
   * Get data to type
   */
  public function get($index)
  {
    if (isset($this->types[$index])) {
      return $this->types[$index];
    }

    return $this->types[self::CHECKBOX];
  }

  /**
   * Index Method To API
   */
  public function index()
  {
    //Instance response
    $response = [];
    //AMp status
    foreach ($this->types as $key => $type) {
      array_push($response, ['value' => $key, 'label' => $type['title'], 'dynamic' => $type['dynamic'] ]);
    }
    //Repsonse
    return collect($response);
  }
}
