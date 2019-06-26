<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\PaymentMethod;
use Modules\Icommerce\Http\Requests\CreatePaymentMethodRequest;
use Modules\Icommerce\Http\Requests\UpdatePaymentMethodRequest;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PaymentMethodController extends AdminBaseController
{
    /**
     * @var PaymentMethodRepository
     */
    private $paymentmethod;

    public function __construct(PaymentMethodRepository $paymentmethod)
    {
        parent::__construct();

        $this->paymentmethod = $paymentmethod;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $paymentMethods = $this->paymentmethod->all();
        return view('icommerce::admin.paymentmethods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.paymentmethods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePaymentMethodRequest $request
     * @return Response
     */
    public function store(CreatePaymentMethodRequest $request)
    {
        $this->paymentmethod->create($request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::paymentmethods.title.paymentmethods')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PaymentMethod $paymentmethod
     * @return Response
     */
    public function edit(PaymentMethod $paymentmethod)
    {
        return view('icommerce::admin.paymentmethods.edit', compact('paymentmethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PaymentMethod $paymentmethod
     * @param  UpdatePaymentMethodRequest $request
     * @return Response
     */
    public function update(PaymentMethod $paymentmethod, UpdatePaymentMethodRequest $request)
    {
  
  
      // init
      $options['init'] = $paymentmethod->options->init;
  
      //Image
      if(isset($request['mainimage'])){
        $requestimage = $request['mainimage'];
        unset($request['mainimage']);
    
        if(($requestimage==NULL) || (!empty($requestimage)) ){
          $requestimage = $this->saveImage($requestimage,"assets/{$paymentmethod->name}/1.jpg");
        }
        $options['mainimage'] = $requestimage;
    
      }
      // Extra Options
      foreach ($paymentmethod->options as $key => $value) {
        if($key!="mainimage" && $key!="init"){
          $options[$key] = $request[$key];
          unset($request[$key]);
        }
      }
      $request['options'] = $options;

      
      $this->paymentmethod->update($paymentmethod, $request->all());

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => $paymentmethod->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PaymentMethod $paymentmethod
     * @return Response
     */
    public function destroy(PaymentMethod $paymentmethod)
    {
        $this->paymentmethod->destroy($paymentmethod);

        return redirect()->route('admin.icommerce.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::paymentmethods.title.paymentmethods')]));
    }
}
