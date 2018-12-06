<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\CartProduct;
use Modules\Icommerce\Http\Requests\CartProductRequest;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CartProductController extends AdminBaseController
{
    /**
     * @var CartProductRepository
     */
    private $cartproduct;

    public function __construct(CartProductRepository $cartproduct)
    {
        parent::__construct();

        $this->cartproduct = $cartproduct;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$cartproducts = $this->cartproduct->all();

        return view('icommerce::admin.cartproducts.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.cartproducts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCartProductRequest $request
     * @return Response
     */
    public function store(CartProductRequest $request)
    {
        $this->cartproduct->create($request->all());

        return redirect()->route('admin.icommerce.cartproduct.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::cartproducts.title.cartproducts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CartProduct $cartproduct
     * @return Response
     */
    public function edit(CartProduct $cartproduct)
    {
        return view('icommerce::admin.cartproducts.edit', compact('cartproduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CartProduct $cartproduct
     * @param  UpdateCartProductRequest $request
     * @return Response
     */
    public function update(CartProduct $cartproduct, CartProductRequest $request)
    {
        $this->cartproduct->update($cartproduct, $request->all());

        return redirect()->route('admin.icommerce.cartproduct.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::cartproducts.title.cartproducts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CartProduct $cartproduct
     * @return Response
     */
    public function destroy(CartProduct $cartproduct)
    {
        $this->cartproduct->destroy($cartproduct);

        return redirect()->route('admin.icommerce.cartproduct.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::cartproducts.title.cartproducts')]));
    }
}
