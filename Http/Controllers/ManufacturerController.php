<?php

namespace Modules\Icommerce\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Route;
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

    $manufacturers = $this->manufacturer->getItemsBy(json_decode(json_encode(["params" => ["include" => []]])));
    
    //$dataRequest = $request->all();
    
    return view($tpl, compact('manufacturers'));
  }
  
  
}
