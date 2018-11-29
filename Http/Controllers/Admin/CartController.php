<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Cart;
use Modules\Icommerce\Http\Requests\CreateCartRequest;
use Modules\Icommerce\Http\Requests\UpdateCartRequest;
use Modules\Icommerce\Repositories\CartRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CartController extends AdminBaseController
{
    /**
     * @var CartRepository
     */
    private $cart;

    public function __construct(CartRepository $cart)
    {
        parent::__construct();

        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$carts = $this->cart->all();

        return view('icommerce::admin.carts.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.carts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCartRequest $request
     * @return Response
     */
    public function store(CreateCartRequest $request)
    {
        $this->cart->create($request->all());

        return redirect()->route('admin.icommerce.cart.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::carts.title.carts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Cart $cart
     * @return Response
     */
    public function edit(Cart $cart)
    {
        return view('icommerce::admin.carts.edit', compact('cart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Cart $cart
     * @param  UpdateCartRequest $request
     * @return Response
     */
    public function update(Cart $cart, UpdateCartRequest $request)
    {
        $this->cart->update($cart, $request->all());

        return redirect()->route('admin.icommerce.cart.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::carts.title.carts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Cart $cart
     * @return Response
     */
    public function destroy(Cart $cart)
    {
        $this->cart->destroy($cart);

        return redirect()->route('admin.icommerce.cart.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::carts.title.carts')]));
    }
}
