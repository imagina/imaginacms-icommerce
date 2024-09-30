<?php

namespace Modules\Icommerce\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class ManufacturerController extends BaseApiController
{
  protected $auth;
  
  private $manufacturer;
  
  
  public function __construct(
    ManufacturerRepository $manufacturer
  )
  {
    parent::__construct();
    
    $this->manufacturer = $manufacturer;
    
  }
  
  
  // view products by category
  public function index(Request $request)
  {
    $argv = explode("/", $request->path());

    
    $tpl = 'icommerce::frontend.manufacturer.index';
    $ttpl = 'icommerce.manufacturer.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;

    $manufacturers = $this->manufacturer->getItemsBy(json_decode(json_encode( ["include" => [], "order" => ["field" => "slug", "way" => "asc"]])));
    
    //$dataRequest = $request->all();
    
    return view($tpl, compact('manufacturers'));
  }
  
  
}
