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
         $mainimage=0;
         $options="";
         unset($request['_token']);
         if($request->type=='text'){
           $options=['text'=>$request->text];
           unset($request['text']);
           unset($request['background']);
           unset($request['mainimage']);
         }else if($request->type=="background"){
           $options=['background'=>$request->background];
           unset($request['text']);
           unset($request['mainimage']);
           unset($request['background']);
         }else if($request->type=="image"){
           unset($request['text']);
           unset($request['background']);
           $mainimage=$request['mainimage'];
           unset($request['mainimage']);
         }
         $request['options']=json_encode($options);
         $option_value=$this->option_value->create($request->all());
         if($request->type=="image"){
           $image=$this->saveImage($mainimage,"assets/icommerce/option_values/".$option_value->id.".jpg");
           $options=['image'=>$image];
           $option_value->options=json_encode($options);
           $option_value->update();
        }
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
         $entity=$this->entity;
         $option_value->options=json_decode($option_value->options);
         return view('icommerce::admin.option_values.edit', compact('option_value','entity'));
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
         unset($request['_token']);
         unset($request['_method']);
         $options="";
         if($request->type=='text'){
           $options=['text'=>$request->text];
           unset($request['text']);
           unset($request['background']);
           unset($request['mainimage']);
         }else if($request->type=="background"){
           $options=['background'=>$request->background];
           unset($request['text']);
           unset($request['mainimage']);
           unset($request['background']);
         }else if($request->type=="image"){
           unset($request['text']);
           unset($request['background']);
           $mainimage=$request['mainimage'];
           unset($request['mainimage']);
           $options=json_decode($option_value->options);
         }
         $request['options']=json_encode($options);
         $this->option_value->update($option_value, $request->all());
         $b=0;
         $optionsOfOptionValue=json_decode($option_value->options);
         if(isset($optionsOfOptionValue->image)&&!empty($optionsOfOptionValue->image)){
           $b=1;
         }
         if($request->type=="image"){
           if($b==1){
             //Exist image in db - update image
             if($mainimage!=$optionsOfOptionValue->image){
               $image=$this->saveImage($mainimage,"assets/icommerce/option_values/".$option_value->id.".jpg");
               $options=['image'=>$image];
               $option_value->options=json_encode($options);
               $option_value->update();
             }
           }else{
             //create image
             $image=$this->saveImage($mainimage,"assets/icommerce/option_values/".$option_value->id.".jpg");
             $options=['image'=>$image];
             $option_value->options=json_encode($options);
             $option_value->update();
           }
        }

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


}//saveImage()
}
