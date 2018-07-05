<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Icommerce\Repositories\ShippingRepository;
use Anam\Phpcart\Cart as Carting;

class CartController extends Controller
{

    private $cart;
    private $shipping;

    public function __construct(ShippingRepository $shipping) {
        $this->cart = new Carting();
        $this->shipping = $shipping; 
    }

    // guarda un producto en le carrito
    public function add_cart(Request $request)
    {
        $data = $request->all();
        $status = false;

        if (isset($data) && !empty($data)) {
            foreach ($data as $product) {
                $price = isset($product['price_discount']) ? $product['price_discount'] : $product['price'];

                $this->cart->add([
                    'id' => $product['id'],
                    'name' => $product['title'],
                    'quantity' => $product['quantity_cart'],
                    'price' => str_replace(',', '', $price),
                    'format_price' => $price,
                    'weight' => isset($product['weight']) ? $product['weight'] : '',
                    'mainimage' => $product['mainimage'],
                    'url' => $product['url'],
                    'sku' => $product['sku'],
                    'width' => isset($product['width']) ? $product['width'] : 0,
                    'length' => isset($product['length']) ? $product['length'] : 0,
                    'height' => isset($product['height']) ? $product['height'] : 0,
                    'freeshipping' => isset($product['freeshipping']) ? $product['freeshipping'] : 0,
                ]);
            }
            $status = true;
        }

        return [
            "status" => $status,
            'items' => $this->cart->getItems()
        ];
    }

    // devuelve los productos que hay en el carrito
    public function get_cart() {
        $items = $this->cart->getItems();
        $weight = 0;

        foreach ($items as $index => $item){
            $item->weight ? $weight += $item->weight : false;
        }

        //dd($this->cart->getTotal());

        return [
            'items' => $items,
            'quantity' => $this->cart->totalQuantity(),
            'total' => number_format($this->cart->getTotal(),2),
            'weight' => $weight
        ];
    }

    /*elimina todos los productos del carrito*/
    public function clear_cart(){
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
    public function delelet_all() {
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
        $shipping = $this->shipping->getShippingsMethods($items,$request->postCode,$request->countryISO,$request->country);


        return $shipping;
    }
}
