<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Option;
use Modules\Icommerce\Entities\Option_Value;

use Modules\Icommerce\Http\Requests\OptionRequest;

use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Icommerce\Repositories\Option_ValueRepository;
use Modules\Icommerce\Repositories\Product_Option_ValueRepository;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use App;

class OptionController extends AdminBaseController
{
    /**
     * @var OptionRepository
     */
    private $option;
    private $entity;
    private $optionValue;
    private $product_option_value;

    public function __construct(OptionRepository $option, Option $entity,Option_ValueRepository $optionValue,Product_Option_ValueRepository $product_option_value)
    {
        parent::__construct();

        $this->option = $option;
        $this->entity = $entity;
        $this->optionValue = $optionValue;
        $this->product_option_value = $product_option_value;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $options = Option::all();
        $entity = $this->entity;
        return view('icommerce::admin.options.index', compact('options','entity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $entity = $this->entity;
        $parentOptions=$this->option->findParentOptions();
        return view('icommerce::admin.options.create',compact('entity','parentOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOptionRequest $request
     * @return Response
     */
    public function store(OptionRequest $request)
    {
        if(empty($request->sort_order)){
            $request["sort_order"] = 0;
        }

        $option = $this->option->create($request->except(['_token','description_value','sort_order_value','mainimage']));

        // if($option){
        //     if(isset($request->description_value) && ($request->type != "text" || $request->type != "textarea") ){
        //         $vdv = $request->description_value;
        //         $vso = $request->sort_order_value;
        //         $vmi = $request->mainimage;
        //         foreach ($vdv as $index => $val) {
        //
        //             if($vso[$index]==null)
        //                 $vso[$index]=0;
        //
        //             // Imagen
        //             if(!empty($vmi[$index] && !empty($option->id))) {
        //                 $mainimage = $this->saveImage($vmi[$index],"assets/icommerce/option/".$option->id."/".$index.".jpg");
        //             }
        //
        //             $param = array(
        //                 'option_id'     => $option->id,
        //                 'image'         => $mainimage,
        //                 'description'   => $val,
        //                 'sort_order'    => $vso[$index],
        //             );
        //             $this->optionValue->create($param);
        //         }
        //     }
        // }

        return redirect()->route('admin.icommerce.option.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::options.title.options')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Option $option
     * @return Response
     */
    public function edit(Option $option, Request $request)
    {
        $entity = $this->entity;
        $parentOptions=$this->option->findParentOptions();
        // $optionValues = $this->optionValue->findByParentId($option->id);

        return view('icommerce::admin.options.edit', compact('option','parentOptions','entity','request'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  id
     * @return Response
     */
    public function deleteOptionValue($id)
    {
        $response = array();
        $response['status'] = 'error'; //default

        try {
            $optionValues = $this->optionValue->findById($id);

            $product_option_value = $this->product_option_value->findByOptionValueId($optionValues->id);

            if ( $product_option_value->isEmpty() ){
                $optionValues->delete();
                $response['status'] = 'success'; //default
            }

            return response()->json($response);
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = $t->getMessage();
            Log::error($t);
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Option $option
     * @param  UpdateOptionRequest $request
     * @return Response
     */
    public function update(Option $option, OptionRequest $request)
    {
        if(empty($request->sort_order)){
            $request["sort_order"] = 0;
        }

        $option = $this->option->update($option,$request->except(['_token','_method']));


        return redirect()->route('admin.icommerce.option.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::options.title.options')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Option $option
     * @return Response
     */
    public function destroy(Option $option)
    {
        $this->option->destroy($option);

        return redirect()->route('admin.icommerce.option.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::options.title.options')]));
    }

    /**
     * Save Image.
     *
     * @param  Value
     * @param  Destination
     * @return Response
     */
    public function saveImage($value,$destination_path)
    {

        $disk = "publicmedia";

        //Defined return.
        if(ends_with($value,'.jpg')) {
            return $value;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // resize and prevent possible upsizing

            $image->resize(config('asgard.iblog.config.imagesize.width'), config('asgard.iblog.config.imagesize.height'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            if(config('asgard.iblog.config.watermark.activated')){
                $image->insert(config('asgard.iblog.config.watermark.url'), config('asgard.iblog.config.watermark.position'), config('asgard.iblog.config.watermark.x'), config('asgard.iblog.config.watermark.y'));
            }
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path, $image->stream('jpg','80'));


            // Save Thumbs
            \Storage::disk($disk)->put(
                str_replace('.jpg','_mediumThumb.jpg',$destination_path),
                $image->fit(config('asgard.iblog.config.mediumthumbsize.width'),config('asgard.iblog.config.mediumthumbsize.height'))->stream('jpg','80')
            );

            \Storage::disk($disk)->put(
                str_replace('.jpg','_smallThumb.jpg',$destination_path),
                $image->fit(config('asgard.iblog.config.smallthumbsize.width'),config('asgard.iblog.config.smallthumbsize.height'))->stream('jpg','80')
            );

            // 3. Return the path
            return $destination_path;
        }

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($destination_path);

            // set null in the database column
            return null;
        }


    }
}
