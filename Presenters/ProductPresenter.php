<?php

namespace Modules\Icommerce\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Icommerce\Entities\OrderItem;
use Modules\Icommerce\Entities\Status;

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

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->post = app('Modules\Icommerce\Repositories\ProductRepository');
        $this->status = app('Modules\Icommerce\Entities\Status');
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

    public function priceAfterDiscounts () {

      $now = date('Y-m-d');

      $basePrice = $this->entity->price;
      $newPrice = $basePrice;
      $totalDiscounts = [];
      $discounts = $this->entity->discounts()
        ->orderBy('priority', 'asc')
        ->get();

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


    public function taxes () {
      return 0;
    }

    private function calcDiscount ($discount, $value) {
      if($discount->criteria == 'fixed'){
        return intval ($discount->discount);
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

}
