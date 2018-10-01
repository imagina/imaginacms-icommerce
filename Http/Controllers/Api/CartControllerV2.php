<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Icommerce\Repositories\ShippingRepository;
use Anam\Phpcart\Cart;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Transformers\ProductTransformer;

class CartController extends Controller
{

  private $cart;
  private $shipping;
  private $product;

  public function __construct(ShippingRepository $shipping, ProductRepository $product, Cart $cart)
  {
    $this->cart =$cart;
    $this->shipping = $shipping;
    $this->product = $product;
  }

  // guarda un producto en le carrito
  public function store(Request $request)
  {
    $items= $request->all();
    $status = false;
    try {
      if (isset($items) && !empty($items)) {
        foreach ($items as $data) {

          $product = new ProductTransformer($this->product->find($data['id']));
          $product = json_decode(json_encode($product));
          $this->cart->add([
            'id' => $product->id,
            'name' => $product->title,
            'quantity' => $data['quantity_cart'],
            'price' => $product->unformatted_price_discount ?? $product->unformatted_price,
            'format_price' => $product->unformatted_price_discount != 0 ? $product->price_discount : $product->price,
            'weight' => $product->weight ?? '',
            'mainimage' => $product->mainimage,
            'url' => $product->url,
            'sku' => $product->sku,
            'width' => $product->width ?? 0,
            'length' => $product->length ?? 0,
            'height' => $product->height ?? 0,
            'freeshipping' => $product->freeshipping ?? 0,
          ]);
        }
        $status = true;
      }

      return [
        "status" => $status,
        'items' => $this->cart->getItems()
      ];

    } catch (\Exception $e) {
      \Log::error($e);
    }

  }

  // devuelve los productos que hay en el carrito
  public function items()
  {
    $items = $this->cart->getItems();
    $weight = 0;

    foreach ($items as $index => $item) {
      $item->weight ? $weight += $item->weight : false;
    }

    //dd($this->cart->getTotal());

    return [
      'items' => $items,
      'quantity' => $this->cart->totalQuantity(),
      'total' => formatMoney($this->cart->getTotal()),
      'weight' => $weight
    ];
  }

  /*elimina todos los productos del carrito*/
  public function clear_cart()
  {
    $this->cart->clear();
    return $this->get_cart();
  }

  // Elimina un item del carrito
  public function delete_item()
  {
    $id = $_GET['id'];
    $this->cart->remove($id);
    return $this->get_cart();
  }

  // Eliminar los items del carrito
  public function delete_all()
  {
    $this->cart->clear();
    return $this->get_cart();
  }

  // Actualiza la cantidad de items por producto
  public function update(Request $request)
  {
    $data = $request->all();

    $this->cart->update([
      'id' => $data['id'],
      'quantity' => $data['quantity']
    ]);

    return $this->get_cart();
  }


  public function shippingMethods(Request $request)
  {
    $items = $this->get_cart();
    $options = $request->all();

    $shipping = $this->shipping->getShippingsMethods($items, $options);

    return $shipping;
  }
}
