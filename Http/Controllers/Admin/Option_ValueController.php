<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Option_Value;
use Modules\Icommerce\Entities\Option;
use Modules\Icommerce\Http\Requests\CreateOption_ValueRequest;
use Modules\Icommerce\Http\Requests\UpdateOption_ValueRequest;
use Modules\Icommerce\Repositories\Option_ValueRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerce\Repositories\OptionRepository;

class Option_ValueController extends AdminBaseController
{
    /**
     * @var Option_ValueRepository
     */
    private $option_value;
    private $option;
    private $entity;

    public function __construct(Option_ValueRepository $option_value,OptionRepository $option,Option_Value $entity)
    {
        parent::__construct();

        $this->option = $option;
        $this->entity = $entity;
        $this->option_value = $option_value;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Option $option)
    {
        $option_values=Option_Value::where('option_id',$option->id)->get();
        return view('icommerce::admin.option_values.index',['option'=>$option,'option_values'=>$option_values]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Option $option)
    {
        return view('icommerce::admin.option_values.create',['option'=>$option,'entity'=>$this->entity]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOption_ValueRequest $request
     * @return Response
     */
    public function store(CreateOption_ValueRequest $request)
    {
        unset($request['_token']);
        $option_value=$this->option_value->create($request->all());
        return redirect()->route('admin.icommerce.option_value.index',[$option_value->option_id])
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::option_values.title.option_values')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Option_Value $option_value
     * @return Response
     */
    public function edit(Option_Value $option_value)
    {
        return view('icommerce::admin.option_values.edit', compact('option_value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Option_Value $option_value
     * @param  UpdateOption_ValueRequest $request
     * @return Response
     */
    public function update(Option_Value $option_value, UpdateOption_ValueRequest $request)
    {
        $this->option_value->update($option_value, $request->all());

        return redirect()->route('admin.icommerce.option_value.index',[$option_value->option_id])
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::option_values.title.option_values')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Option_Value $option_value
     * @return Response
     */
    public function destroy(Option_Value $option_value)
    {
        $this->option_value->destroy($option_value);

        return redirect()->route('admin.icommerce.option_value.index',[$option_value->option_id])
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::option_values.title.option_values')]));
    }
}
