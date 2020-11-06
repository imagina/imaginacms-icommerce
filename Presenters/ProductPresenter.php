<?php

namespace Modules\Icommerce\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Icommerce\Entities\OrderItem;
use Modules\Icommerce\Entities\Status;
use Illuminate\Support\Facades\Auth;
use Modules\Iprofile\Entities\Department;
use Modules\Icurrency\Support\Facades\Currency;

class ProductPresenter extends Presenter
{
  /**
   * @var \Modules\Icommerce\Entities\Status
   */
  protected $status;
  /**
   * @var \Modules\Icommerce\Repositories\ProductRepository
   */
  private $post;

  private $department;

  public function __construct($entity)
  {
    parent::__construct($entity);
    $this->post = app('Modules\Icommerce\Repositories\ProductRepository');
    $this->status = app('Modules\Icommerce\Entities\Status');
    $this->department = app('Modules\Iprofile\Repositories\DepartmentRepository');
  }

  /**
   * Get the post status
   * @return string
   */
  public function status()
  {
    return $this->status->get($this->entity->status);
  }

  /**
   * Getting the label class for the appropriate status
   * @return string
   */
  public function statusLabelClass()
  {
    switch ($this->entity->status) {
      case Status::DISABLED:
        return 'red';
        break;
      case Status::ENABLED:
        return 'green';
        break;
      default:
        return 'red';
        break;
    }
  }

  public function totalDiscounts ( ) {

    $now = date('Y-m-d');

    $basePrice = $this->entity->price;
    $newPrice = $basePrice;
    $totalDiscounts = [];
    $userId = Auth::user() ? Auth::user()->id : 0;

    if ($userId){
      $departments = Department::whereHas('users', function ($q) use ($userId){
        $q->where('iprofile__user_department.user_id', $userId);
      })->pluck('id');
    }

    $departments[] = null;

    $discounts = $this->entity->discounts()
      ->orderBy('priority', 'asc')
      ->whereDate('date_end', '>=', $now)
      ->whereDate('date_start', '<=', $now)
      ->get();

    $discounts = $discounts->whereIn('department_id', $departments);

    foreach ($discounts as $key => $discount){
      $valueDiscount = $this->calcDiscount($discount, $newPrice);


      if ( isset($discounts[$key+1]) && $discounts[$key+1]->priority == $discounts[$key]->priority ){
        $newPrice = $newPrice;
      } else {
        $newPrice = $this->updatePrice($basePrice, $totalDiscounts)/*$newPrice - $valueDiscount*/;
      }
      $totalDiscounts[]= $valueDiscount;

    }

    $response = 0;
    for ($i = 0; $i < count($totalDiscounts); $i++){
      $response += floatval($totalDiscounts[$i]);
    }


    return $response;
  }

  public function discount ( ) {

    $now = date('Y-m-d');

    $basePrice = $this->entity->price;
    $newPrice = $basePrice;
    $totalDiscounts = [];
    $userId = Auth::user() ? Auth::user()->id : 0;
    $departments = [];
    if ($userId){
      $departments = \DB::connection(env('DB_CONNECTION', 'mysql'))
        ->table('iprofile__user_department')->select("department_id")
        ->where('user_id', $userId)
        ->pluck('department_id');

    }

    $discount = $this->entity->discounts()
      ->orderBy('priority', 'desc')
      ->orderBy('created_at', 'asc')
      ->where('date_end', '>=', $now)
      ->where('date_start', '<=', $now)
      ->where(function ($query) use ($departments){
        $query->whereIn('department_id', $departments)
          ->orWhereNull('department_id');
      })
      ->first();


    if(isset($discount->id)){
    return $discount;

    }else{

      return null;
    }

  }

  private function calcDiscount ($discount, $value) {
    if($discount->criteria == 'fixed'){
      return  ($value - $discount->discount);
    }

    if($discount->criteria == 'percentage'){
      return floatval (($value * $discount->discount) / 100 );
    }
  }

  private function updatePrice ($price, $discounts) {
    $response = $price;
    for ($i = 0; $i < count($discounts); $i++){
      $response -= $discounts[$i];
    }
    return $response;
  }

  public function totalTaxes () {
    $basePrice = $this->entity->price ? $this->entity->price : 0;
    $taxes = isset($this->entity->taxClass) && isset($this->entity->taxClass->rates) ? $this->entity->taxClass->rates : [];
    $totalTaxes = 0;
    foreach ($taxes as $tax){
      $totalTaxes += floatval( ($basePrice * $tax->rate) / 100) ;
    }
    return $totalTaxes;
  }

  public function price(){
    $price=$this->entity->price;
    $auth=\Auth::user();
    if(!$auth){
      if(count($this->entity->priceLists->where('status',1))>0){
        foreach($this->entity->priceLists as $pList){
          if($pList->related_entity=="Modules\Iprofile\Entities\Role"){
            if($auth && $auth->hasRoleId($pList->related_id)){
              $price=$pList->pivot->price;
            }
          }else{
            $price=$pList->pivot->price;
          }
        }//
      }//has priceLists
    }
    return Currency::convert($price);
  }//
}
