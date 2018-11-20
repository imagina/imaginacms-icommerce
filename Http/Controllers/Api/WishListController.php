<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Mockery\CountValidator\Exception;

use Illuminate\Http\Request;
use Modules\User\Contracts\Authentication;
use App\Http\Controllers\Controller;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\WishlistRepository;

use Modules\Icommerce\Transformers\ProductTransformer;

use Modules\Core\Http\Controllers\BasePublicController;

class WishListController extends BasePublicController
{

    protected $auth;
    private $product;
    private $wishlist;

    /**
     * WishListController constructor.
     * @param ProductRepository $product
     * @param WishlistRepository $wishlist
     * @param Authentication $auth
     */
    public function __construct(
        ProductRepository $product,
        WishlistRepository $wishlist)
    {
        parent::__construct();
        $this->product = $product;
        $this->wishlist = $wishlist;
        $this->auth = app(Authentication::class);
    }

    // get products of witshlist
    public function getWishList() {
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        $wishlist = [];
        $user_id = $_GET['id'];

        $dataWishlist = $this->wishlist->whereUserId($user_id);

        foreach ($dataWishlist as $product){
            $options = json_decode(json_decode($product->options));

            /*valida la imagen del producto*/
            if (isset($options->mainimage) && !empty($options->mainimage)){
                $image = url($options->mainimage);
            }else{
                $image = url('modules/icommerce/img/product/default.jpg');
            }
            $title = json_decode($product->title);

            array_push($wishlist,[
                'id' => $product->id,
                'title' => $title->$locale,
                'url' => url($product->slug),
                'price' => $product->price,
                'mainimage' => $image,
            ]);
        }

        return $wishlist;
    }

    // Agregar producto a la lista de deseo
    public function addWishList(Request $request)
    {
        $data = $request->all();
        $this->wishlist->create($data);
    }

    // Eliminar producto a la lista de deseo
    public function deleteWishList(Request $request)
    {
        $data = $request->all();
        $result = $this->wishlist->whereUserProduct($data["user_id"], $data["product_id"]);

        $result->delete();
    }

}
