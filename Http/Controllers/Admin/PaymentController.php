<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Payment;
use Modules\Icommerce\Http\Requests\PaymentRequest;

use Modules\Icommerce\Repositories\PaymentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PaymentController extends AdminBaseController
{
    /**
     * @var PaymentRepository
     */
    private $payment;

    public function __construct(PaymentRepository $payment)
    {
        parent::__construct();

        $this->payment = $payment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(PaymentRequest $request)
    {
        $paymentMethods = config('asgard.icommerce.config.paymentmethods');
        return view('icommerce::admin.payments.index', compact('paymentMethods','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.payments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePaymentRequest $request
     * @return Response
     */
    public function store(PaymentRequest $request)
    {
        $this->payment->create($request->all());

        return redirect()->route('admin.icommerce.payment.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::payments.title.payments')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Payment $payment
     * @return Response
     */
    public function edit(Payment $payment)
    {
        return view('icommerce::admin.payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Payment $payment
     * @param  UpdatePaymentRequest $request
     * @return Response
     */
    public function update(Payment $payment, PaymentRequest $request)
    {
        $this->payment->update($payment, $request->all());

        return redirect()->route('admin.icommerce.payment.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::payments.title.payments')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Payment $payment
     * @return Response
     */
    public function destroy(Payment $payment)
    {
        $this->payment->destroy($payment);

        return redirect()->route('admin.icommerce.payment.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::payments.title.payments')]));
    }
}
