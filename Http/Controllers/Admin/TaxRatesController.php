<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\TaxRates;
use Modules\Ilocations\Entities\Geozones;
use Modules\Icommerce\Http\Requests\CreateTaxRatesRequest;
use Modules\Icommerce\Http\Requests\UpdateTaxRatesRequest;
use Modules\Icommerce\Repositories\TaxRatesRepository;
use Modules\Ilocations\Repositories\GeozonesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TaxRatesController extends AdminBaseController
{
    /**
     * @var TaxRatesRepository
     */
    private $taxrates;
    private $geozones;

    public function __construct(TaxRatesRepository $taxrates,GeozonesRepository $geozones)
    {
        parent::__construct();

        $this->taxrates = $taxrates;
        $this->geozones = $geozones;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $taxrates = $this->taxrates->getAll();
        // dd($taxrates);
        return view('icommerce::admin.taxrates.index', compact('taxrates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
      $geozones=$this->geozones->getAll();
      if(count($geozones)>0)
        return view('icommerce::admin.taxrates.create',['geozones'=>$geozones]);
      else
        return redirect()->route('admin.ilocations.geozones.index')->with('error','You need to register at least one geozone');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTaxRatesRequest $request
     * @return Response
     */
    public function store(CreateTaxRatesRequest $request)
    {
      $taxRate=new TaxRates();
      $taxRate->name=$request->name;
      $taxRate->rate=$request->rate;
      $taxRate->type=$request->type;
      $taxRate->geozone_id=$request->geozone_id;
      $taxRate->customer=isset($request->customer);
      $taxRate->save();
        // $this->taxrates->create($request->all());
        return redirect()->route('admin.icommerce.taxrates.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::taxrates.title.taxrates')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TaxRates $taxrates
     * @return Response
     */
    public function edit(TaxRates $taxrates)
    {
        $geozones=$this->geozones->getAll();
        return view('icommerce::admin.taxrates.edit', compact('taxrates','geozones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TaxRates $taxrates
     * @param  UpdateTaxRatesRequest $request
     * @return Response
     */
    public function update(TaxRates $taxrates, UpdateTaxRatesRequest $request)
    {
        $taxrates->name=$request->name;
        $taxrates->rate=$request->rate;
        $taxrates->type=$request->type;
        $taxrates->geozone_id=$request->geozone_id;
        $taxrates->customer=isset($request->customer);
        $taxrates->update();
        // $this->taxrates->update($taxrates, $request->all());

        return redirect()->route('admin.icommerce.taxrates.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::taxrates.title.taxrates')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TaxRates $taxrates
     * @return Response
     */
    public function destroy(TaxRates $taxrates)
    {
        $this->taxrates->destroy($taxrates);

        return redirect()->route('admin.icommerce.taxrates.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::taxrates.title.taxrates')]));
    }
}
