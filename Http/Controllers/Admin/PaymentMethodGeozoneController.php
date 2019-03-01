<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\PaymentMethodGeozone;
use Modules\Icommerce\Http\Requests\CreatePaymentMethodGeozoneRequest;
use Modules\Icommerce\Http\Requests\UpdatePaymentMethodGeozoneRequest;
use Modules\Icommerce\Repositories\PaymentMethodGeozoneRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PaymentMethodGeozoneController extends AdminBaseController
{
    /**
     * @var PaymentMethodGeozoneRepository
     */
    private $paymentmethodgeozone;

    public function __construct(PaymentMethodGeozoneRepository $paymentmethodgeozone)
    {
        parent::__construct();

        $this->paymentmethodgeozone = $paymentmethodgeozone;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$paymentmethodgeozones = $this->paymentmethodgeozone->all();

        return view('icommerce::admin.paymentmethodgeozones.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.paymentmethodgeozones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePaymentMethodGeozoneRequest $request
     * @return Response
     */
    public function store(CreatePaymentMethodGeozoneRequest $request)
    {
        $this->paymentmethodgeozone->create($request->all());

        return redirect()->route('admin.icommerce.paymentmethodgeozone.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::paymentmethodgeozones.title.paymentmethodgeozones')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PaymentMethodGeozone $paymentmethodgeozone
     * @return Response
     */
    public function edit(PaymentMethodGeozone $paymentmethodgeozone)
    {
        return view('icommerce::admin.paymentmethodgeozones.edit', compact('paymentmethodgeozone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PaymentMethodGeozone $paymentmethodgeozone
     * @param  UpdatePaymentMethodGeozoneRequest $request
     * @return Response
     */
    public function update(PaymentMethodGeozone $paymentmethodgeozone, UpdatePaymentMethodGeozoneRequest $request)
    {
        $this->paymentmethodgeozone->update($paymentmethodgeozone, $request->all());

        return redirect()->route('admin.icommerce.paymentmethodgeozone.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::paymentmethodgeozones.title.paymentmethodgeozones')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PaymentMethodGeozone $paymentmethodgeozone
     * @return Response
     */
    public function destroy(PaymentMethodGeozone $paymentmethodgeozone)
    {
        $this->paymentmethodgeozone->destroy($paymentmethodgeozone);

        return redirect()->route('admin.icommerce.paymentmethodgeozone.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::paymentmethodgeozones.title.paymentmethodgeozones')]));
    }
}
