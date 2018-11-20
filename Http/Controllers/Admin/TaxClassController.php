<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\TaxClass;
use Modules\Icommerce\Entities\TaxClassRates;
use Modules\Icommerce\Entities\TaxRates;
use Modules\Icommerce\Http\Requests\CreateTaxClassRequest;
use Modules\Icommerce\Http\Requests\UpdateTaxClassRequest;
use Modules\Icommerce\Repositories\TaxClassRepository;
use Modules\Icommerce\Repositories\TaxRatesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TaxClassController extends AdminBaseController
{
  /**
  * @var TaxClassRepository
  */
  private $taxclass;
  private $taxrates;

  public function __construct(TaxClassRepository $taxclass,TaxRatesRepository $taxrates)
  {
    parent::__construct();

    $this->taxclass = $taxclass;
    $this->taxrates = $taxrates;
  }

  /**
  * Display a listing of the resource.
  *
  * @return Response
  */
  public function index()
  {
    $taxclasses = $this->taxclass->all();

    return view('icommerce::admin.taxclasses.index', compact('taxclasses'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return Response
  */
  public function create()
  {
    // $taxrates = TaxRates::all();
    $taxrates=$this->taxrates->getAll();
    return view('icommerce::admin.taxclasses.create',compact('taxrates'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  CreateTaxClassRequest $request
  * @return Response
  */
  public function store(CreateTaxClassRequest $request)
  {
    $TaxClass=new TaxClass();
    $TaxClass->name=$request->name;
    $TaxClass->description=$request->description;
    $TaxClass->save();
    foreach($request->taxrates as $taxratess){
      $taxClassRates=new TaxClassRates();
      $taxClassRates->taxclass_id=$TaxClass->id;
      $taxClassRates->taxrate_id=$taxratess['taxRate'];
      $taxClassRates->based=$taxratess['based'];
      $taxClassRates->priority=$taxratess['priority'];
      $taxClassRates->save();
    }
    // $this->taxclass->create($request->all());
    return ['success'=>1,'message'=>trans('core::core.messages.resource created', ['name' => trans('icommerce::taxclasses.title.taxclasses')])];
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  TaxClass $taxclass
  * @return Response
  */
  public function edit(TaxClass $taxclass)
  {
    $taxClassRates=TaxClassRates::where('taxclass_id',$taxclass->id)->get();
    $taxrates=$this->taxrates->getAll();
    return view('icommerce::admin.taxclasses.edit', compact('taxclass','taxClassRates','taxrates'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  TaxClass $taxclass
  * @param  UpdateTaxClassRequest $request
  * @return Response
  */
  public function update(TaxClass $taxclass, UpdateTaxClassRequest $request)
  {
    $taxclass->name=$request->name;
    $taxclass->description=$request->description;
    $taxclass->update();
    $taxClassRates=TaxClassRates::where('taxclass_id',$taxclass->id)->delete();
    foreach($request->taxrates as $taxratess){
      $taxClassRates=new TaxClassRates();
      $taxClassRates->taxclass_id=$taxclass->id;
      $taxClassRates->taxrate_id=$taxratess['taxRate'];
      $taxClassRates->based=$taxratess['based'];
      $taxClassRates->priority=$taxratess['priority'];
      $taxClassRates->save();
    }
    // $this->taxclass->update($taxclass, $request->all());
    return ['success'=>1,'message'=>trans('core::core.messages.resource updated', ['name' => trans('icommerce::taxclasses.title.taxclasses')])];
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  TaxClass $taxclass
  * @return Response
  */
  public function destroy(TaxClass $taxclass)
  {
    $taxClassRates=TaxClassRates::where('taxclass_id',$taxclass->id)->delete();
    $this->taxclass->destroy($taxclass);

    return redirect()->route('admin.icommerce.taxclass.index')
    ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::taxclasses.title.taxclasses')]));
  }
}
