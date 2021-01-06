<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class Wishlist extends Component
{

 
  public $moduleView;
  public $showButton;

  private $params;
  protected $listeners = ['addToWishList'];

  public function mount(Request $request, $showButton = false)
  {

    $this->moduleView = 'icommerce::frontend.livewire.wishlist';
    $this->showButton = $showButton;
  }

  /**
   * @return wislistRepository
   */
  public function wishlistRepository()
  {
    return app('Modules\Icommerce\Repositories\WishlistRepository');
  }

  /**
   * @return wishListEntity
   */
  public function wishlistEntity()
  {
    return app('Modules\Icommerce\Entities\Wishlist');
  }

  /**
   * Render wishlist
   */
  public function render()
  {
    
    return view($this->moduleView);

  }

  /**
   *  Add product to wishlist
   */
  public function addToWishList($productId)
  {
    $user = \Auth::user();//Get user
    //Validate session
    if (!$user) {
      $this->alert('warning', trans('icommerce::wishlists.messages.unauthenticated'), [
        'position' => 'top-end',
        'iconColor' => setting("isite::brandPrimary", "#fff")
      ]);
    } else {
      //Create or update product
      $this->wishlistEntity()->updateOrCreate(
        ['user_id' => $user->id, 'product_id' => $productId],
        ['user_id' => $user->id, 'product_id' => $productId]
      );

      //Message
      $this->alert('success', trans('icommerce::wishlists.messages.productAdded'), config("asgard.isite.config.livewireAlerts"));
    }
  }

  /**
   * Get user wishlist
   */
  public function getWishListUser($userId)
  {
    $params = json_decode(json_encode([
      "filter" => [
        'user' => $userId
      ]
    ]));
    $products = $this->wishlistRepository()->getItemsBy($params);

    return $products;
  }
}
