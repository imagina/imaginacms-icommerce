<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class Wishlist extends Component
{

 
  public function mount(Request $request)
  {
    
   
  }
  
  /**
   * Get wishlist from user
   */
  public function getWishListUser($userId){

    $params = json_decode(json_encode([
      "filter" => [
        'user' => $userId
        ]
    ]));

    $products = $this->wishlistRepository()->getItemsBy($params);

    return $products;
  }

  /**
   * @return cartRepository
   */
  public function wishlistRepository()
  {
    return  app('Modules\Icommerce\Repositories\WishlistRepository');
  }

  /**
  *	Add product to wishlist
  */
  public function addWishList($productId){


    if(\Auth::user()){

      $userId = \Auth::user()->id;
      $products = $this->getWishListUser($userId);

      //Falta- Check if the product id has been added
      if(count($products)>0){

      }

      $data = [
        "user_id" => $userId;
        "product_id" => $productId
      ];

      $this->wishlistRepository()->create($data);

      $this->alert('success', trans('icommerce::wishlist.message.add'),[
        'position' => 'bottom-end',
        'iconColor' => setting("isite::brandPrimary","#fff")
      ]);


    }else{

      $this->alert('warning', trans('icommerce::wishlist.message.user login'),[
        'position' => 'bottom-end',
        'iconColor' => setting("isite::brandPrimary","#fff")
      ]);

    }

  }
 
  
  public function render()
  {


    $tpl = 'icommerce::frontend.livewire.wishlist';
    $ttpl = 'icommerce.livewire.wishlist';

    if (view()->exists($ttpl)) $tpl = $ttpl;

  }
  
}
