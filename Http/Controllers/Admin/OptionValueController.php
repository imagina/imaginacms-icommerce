<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\OptionValue;
use Modules\Icommerce\Http\Requests\OptionValueRequest;
use Modules\Icommerce\Repositories\OptionValueRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OptionValueController extends AdminBaseController
{
    /**
     * @var OptionValueRepository
     */
    private $optionvalue;

    public function __construct(OptionValueRepository $optionvalue)
    {
        parent::__construct();

        $this->optionvalue = $optionvalue;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$optionvalues = $this->optionvalue->all();

        return view('icommerce::admin.optionvalues.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.optionvalues.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOptionValueRequest $request
     * @return Response
     */
    public function store(OptionValueRequest $request)
    {
        $this->optionvalue->create($request->all());

        return redirect()->route('admin.icommerce.optionvalue.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::optionvalues.title.optionvalues')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OptionValue $optionvalue
     * @return Response
     */
    public function edit(OptionValue $optionvalue)
    {
        return view('icommerce::admin.optionvalues.edit', compact('optionvalue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OptionValue $optionvalue
     * @param  UpdateOptionValueRequest $request
     * @return Response
     */
    public function update(OptionValue $optionvalue, OptionValueRequest $request)
    {
        $this->optionvalue->update($optionvalue, $request->all());

        return redirect()->route('admin.icommerce.optionvalue.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::optionvalues.title.optionvalues')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OptionValue $optionvalue
     * @return Response
     */
    public function destroy(OptionValue $optionvalue)
    {
        $this->optionvalue->destroy($optionvalue);

        return redirect()->route('admin.icommerce.optionvalue.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::optionvalues.title.optionvalues')]));
    }
}
