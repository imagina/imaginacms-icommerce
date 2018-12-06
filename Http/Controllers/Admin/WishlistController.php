<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Wishlist;
use Modules\Icommerce\Http\Requests\WishlistRequest;
use Modules\Icommerce\Repositories\WishlistRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class WishlistController extends AdminBaseController
{
    /**
     * @var WishlistRepository
     */
    private $wishlist;

    public function __construct(WishlistRepository $wishlist)
    {
        parent::__construct();

        $this->wishlist = $wishlist;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$wishlists = $this->wishlist->all();

        return view('icommerce::admin.wishlists.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.wishlists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWishlistRequest $request
     * @return Response
     */
    public function store(WishlistRequest $request)
    {
        $this->wishlist->create($request->all());

        return redirect()->route('admin.icommerce.wishlist.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::wishlists.title.wishlists')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Wishlist $wishlist
     * @return Response
     */
    public function edit(Wishlist $wishlist)
    {
        return view('icommerce::admin.wishlists.edit', compact('wishlist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Wishlist $wishlist
     * @param  UpdateWishlistRequest $request
     * @return Response
     */
    public function update(Wishlist $wishlist, WishlistRequest $request)
    {
        $this->wishlist->update($wishlist, $request->all());

        return redirect()->route('admin.icommerce.wishlist.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::wishlists.title.wishlists')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Wishlist $wishlist
     * @return Response
     */
    public function destroy(Wishlist $wishlist)
    {
        $this->wishlist->destroy($wishlist);

        return redirect()->route('admin.icommerce.wishlist.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::wishlists.title.wishlists')]));
    }
}
