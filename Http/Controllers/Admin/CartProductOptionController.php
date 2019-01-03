<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\CartProductOption;
use Modules\Icommerce\Http\Requests\CreateCartProductOptionRequest;
use Modules\Icommerce\Http\Requests\UpdateCartProductOptionRequest;
use Modules\Icommerce\Repositories\CartProductOptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CartProductOptionController extends AdminBaseController
{
    /**
     * @var CartProductOptionRepository
     */
    private $cartproductoption;

    public function __construct(CartProductOptionRepository $cartproductoption)
    {
        parent::__construct();

        $this->cartproductoption = $cartproductoption;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$cartproductoptions = $this->cartproductoption->all();

        return view('icommerce::admin.cartproductoptions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.cartproductoptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCartProductOptionRequest $request
     * @return Response
     */
    public function store(CreateCartProductOptionRequest $request)
    {
        $this->cartproductoption->create($request->all());

        return redirect()->route('admin.icommerce.cartproductoption.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::cartproductoptions.title.cartproductoptions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CartProductOption $cartproductoption
     * @return Response
     */
    public function edit(CartProductOption $cartproductoption)
    {
        return view('icommerce::admin.cartproductoptions.edit', compact('cartproductoption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CartProductOption $cartproductoption
     * @param  UpdateCartProductOptionRequest $request
     * @return Response
     */
    public function update(CartProductOption $cartproductoption, UpdateCartProductOptionRequest $request)
    {
        $this->cartproductoption->update($cartproductoption, $request->all());

        return redirect()->route('admin.icommerce.cartproductoption.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::cartproductoptions.title.cartproductoptions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CartProductOption $cartproductoption
     * @return Response
     */
    public function destroy(CartProductOption $cartproductoption)
    {
        $this->cartproductoption->destroy($cartproductoption);

        return redirect()->route('admin.icommerce.cartproductoption.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::cartproductoptions.title.cartproductoptions')]));
    }
}
