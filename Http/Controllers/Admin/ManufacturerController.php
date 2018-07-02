<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Manufacturer;

use Modules\Icommerce\Http\Requests\ManufacturerRequest;

use Modules\Icommerce\Repositories\ManufacturerRepository;

use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\User\Contracts\Authentication;

class ManufacturerController extends BcrudController
{
    /**
     * @var ManufacturerRepository
     */
   
    private $auth;

    public function __construct(Authentication $auth)
    {
        parent::__construct();

        $this->auth = $auth;

        $driver = config('asgard.user.config.driver');

         /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Modules\Icommerce\Entities\Manufacturer');
        $this->crud->setRoute('backend/icommerce/manufacturer');
        $this->crud->setEntityNameStrings(trans('icommerce::manufacturers.single'), trans('icommerce::manufacturers.plural'));
        $this->access = [];
        $this->crud->enableAjaxTable();
        $this->crud->orderBy('created_at', 'DESC');
        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('title', 2);

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('icommerce::manufacturers.table.name'),
        ]);

        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'boolean',
            'options' => [
                0 => trans('icommerce::status.disabled'),
                1 => trans('icommerce::status.enabled')
            ]
        ]);

        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => trans('icommerce::common.created_at'),
        ]);

        

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'name',
            'label' => trans('icommerce::manufacturers.table.name'),
            'viewposition' => 'left'
        ]);

        $this->crud->addField([ // image
            'label' => trans('icommerce::common.image'),
            'name' => "mainimage",
            'type' => 'image',
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 0, // ommit or set to 0 to allow any aspect ratio
            'fake' => true,
            'store_in' => 'options',
            'viewposition' => 'left',
        ]);

        $this->crud->addField([ // image
            'label' => __('Media File'),
            'name' => "mediafile",
            'type' => 'upload',
            'upload' => true,
            'fake' => true,
            'disk' => 'publicmedia',
            'store_in' => 'options'

        ]);

        $this->crud->addField([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'radio',
            'options' => [
                0 => trans('icommerce::status.disabled'),
                1 => trans('icommerce::status.enabled')
            ],
            'viewposition' => 'right',
        ]);

       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateManufacturerRequest $request
     * @return Response
     */
    public function store(ManufacturerRequest $request)
    {
         return $this->storeCrud($request);
    }


    /**
     * StoreCRUD
     *
     * @param  
     * @return Response
     */
    public function storeCrud(\Modules\Bcrud\Http\Requests\CrudRequest $request = null)
    {

        $this->crud->hasAccessOrFail('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ($request->input() as $key => $value) {
            if (empty($value) && $value !== '0') {
                $request->request->set($key, null);
            }
        }

        //Imagina- Defaults?
        $requestimage = $request["mainimage"];
        //Put a default image while we save.
        $request["mainimage"] = "assets/icommerce/manufacturer/default.jpg";


        // insert item in the db
        $item = $this->crud->create($request->except(['save_action', '_token', '_method']));
        $this->data['entry'] = $this->crud->entry = $item;


        //Let's save the image for the post.
        if(!empty($requestimage && !empty($item->id))) {
            $mainimage = $this->saveImage($requestimage,"assets/icommerce/manufacturer/".$item->id.".jpg");

            $options = (array)$item->options;
            $options["mainimage"] = $mainimage;

            $item->update($this->crud->compactFakeFields($options));
            //TODO: i don't like the re-save. Find another way to do it.
        }

        // show a success message
        //\Alert::success(trans('bcrud::crud.insert_success'))->flash();

        // redirect the user where he chose to be redirected
        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Manufacturer $manufacturer
     * @param  UpdateManufacturerRequest $request
     * @return Response
     */
    public function update(Manufacturer $manufacturer, ManufacturerRequest $request)
    {
        
        if (!empty($request['mainimage']) && !empty($request['id'])) {
            $request['mainimage'] = $this->saveImage($request['mainimage'], "assets/icommerce/manufacturer/" . $request['id'] . ".jpg");
        }
        return parent::updateCrud($request);
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
     /**
     * Setup.
     */
    public function setup()
    {
        parent::setup();

        $permissions = ['index', 'create', 'edit', 'destroy'];
        $allowpermissions = ['show'];
        foreach($permissions as $permission) {

            if($this->auth->hasAccess("icommerce.manufacturers.$permission")) {
                if($permission=='index') $permission = 'list';
                if($permission=='edit') $permission = 'update';
                if($permission=='destroy') $permission = 'delete';
                $allowpermissions[] = $permission;
            }

            $allowpermissions[] = 'reorder';

        }

        $this->crud->access = $allowpermissions;
    }

}
