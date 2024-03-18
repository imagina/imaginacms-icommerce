<?php

namespace Modules\Icommerce\Presenters;

use Illuminate\Support\Facades\Auth;
use Laracasts\Presenter\Presenter;
use Modules\Icommerce\Entities\Status;
use Modules\Iprofile\Entities\Department;

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
     */
    public function status(): string
    {
        return $this->status->get($this->entity->status);
    }

    /**
     * Getting the label class for the appropriate status
     */
    public function statusLabelClass(): string
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

    public function totalDiscounts()
    {
        $now = date('Y-m-d');

        $basePrice = $this->entity->price;
        $newPrice = $basePrice;
        $totalDiscounts = [];
        $userId = Auth::user() ? Auth::user()->id : 0;

        if ($userId) {
            $departments = Department::whereHas('users', function ($q) use ($userId) {
                $q->where('iprofile__user_department.user_id', $userId);
            })->pluck('id');
        }

        $departments[] = null;

        $discounts = $this->entity->discounts()
            ->orderBy('created_at', 'desc')
            ->whereDate('date_end', '>=', $now)
            ->whereDate('date_start', '<=', $now)
            ->get();

        $discounts = $discounts->whereIn('department_id', $departments);

        foreach ($discounts as $key => $discount) {
            $valueDiscount = $this->calcDiscount($discount, $newPrice);

            if (isset($discounts[$key + 1]) && $discounts[$key + 1]->priority == $discounts[$key]->priority) {
                $newPrice = $newPrice;
            } else {
                $newPrice = $this->updatePrice($basePrice, $totalDiscounts)/*$newPrice - $valueDiscount*/;
            }
            $totalDiscounts[] = $valueDiscount;
        }

        $response = 0;
        for ($i = 0; $i < count($totalDiscounts); $i++) {
            $response += floatval($totalDiscounts[$i]);
        }

        return $response;
    }

    public function discount()
    {
        $now = date('Y-m-d');

        $basePrice = $this->entity->price;
        $newPrice = $basePrice;
        $totalDiscounts = [];
        $userId = Auth::user() ? Auth::user()->id : 0;
        $departments = [];
        if ($userId) {
            $departments = \DB::connection(env('DB_CONNECTION', 'mysql'))
              ->table('iprofile__user_department')->select('department_id')
              ->where('user_id', $userId)
              ->pluck('department_id');
        }

        $discount = $this->entity->discounts()
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->where('date_end', '>=', $now)
            ->where('date_start', '<=', $now)
            ->where(function ($query) use ($departments) {
                $query->whereIn('department_id', $departments)
                  ->orWhereNull('department_id');
            })
            ->first();

        if (isset($discount->id)) {
            return $discount;
        } else {
            return null;
        }
    }

    private function calcDiscount($discount, $value)
    {
        if ($discount->type == 'fixed') {
            return  $value - $discount->value;
        }

        if ($discount->type == 'percentage') {
            return floatval(($value * $discount->value) / 100);
        }
    }

    private function updatePrice($price, $discounts)
    {
        $response = $price;
        for ($i = 0; $i < count($discounts); $i++) {
            $response -= $discounts[$i];
        }

        return $response;
    }

  public function totalTaxes()
  {
      $basePrice = $this->entity->price ? $this->entity->price : 0;
      $taxes = isset($this->entity->taxClass) && isset($this->entity->taxClass->rates) ? $this->entity->taxClass->rates : [];
      $totalTaxes = 0;
      foreach ($taxes as $tax) {
          $totalTaxes += floatval(($basePrice * $tax->rate) / 100);
      }

      return $totalTaxes;
  }

  public function hasRequiredOptions()
  {
      $hasRequiredOptions = false;
      if (isset($this->entity->productOptions)) {
          foreach ($this->entity->productOptions as $productOption) {
              isset($productOption->pivot->required) && $productOption->pivot->required ? $hasRequiredOptions = true : false;
          }
      }

      return $hasRequiredOptions;
  }


  /**
   *  Calculation according to the information of weight, volume, quantity, lenght
   * @param $currencySymbol (validation in partial calculate pum)
   * @param $dynamicPrice (case when a product has options)
   */
  public function getCalculateInfor($currencySymbol,$dynamicPrice)
  {

    $result = "";
    $product = $this->entity;

    $price = (is_null($dynamicPrice)) ? $product->price : $dynamicPrice;

    // Weight Case
    if($product->weight>0){
      $total = $price / $product->weight;
      $unit = getUnitClass($product);
    }else{
      // Length Case
      if($product->length>0){
        $total = $price / $product->length;
        $unit = getUnitClass($product,"length");
      }else{
        // Volumen Case
        if($product->volumen>0){
          $total = $price / $product->volumen;
          $unit = getUnitClass($product,"volume");
        }
        // Quantity Case - TODO
      }
    }

    if(isset($unit)){
      //Final Text
      $result = $unit." ".trans("icommerce::common.to")." ".$currencySymbol."".formatMoney($total);
    }

    return $result;

  }

}
