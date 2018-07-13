<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Http\Requests\IcommerceRequest;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\User\Contracts\Authentication;

class CategoryController extends BcrudController
{
    /**
     * @var CategoryRepository
     */
    private $category;
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
        $this->crud->setModel('Modules\Icommerce\Entities\Category');
        $this->crud->setRoute('backend/icommerce/category');
        $this->crud->setEntityNameStrings(trans('icommerce::categories.single'), trans('icommerce::categories.plural'));
        $this->access = [];
        $this->crud->enableAjaxTable();
        $this->crud->orderBy('title', 'ASC');
        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('title', 2);

        /*
      |--------------------------------------------------------------------------
      | FILTERS
      |--------------------------------------------------------------------------


        // Title Filter
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'title',
            'label' => trans('icommerce::common.title')
        ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'title', 'LIKE', "%$value%");
            });

        // Date Filter
        $this->crud->addFilter([
            'type' => 'date',
            'name' => 'date',
            'label' => trans('icommerce::common.created_at')
        ],
            false,
            function ($value) {
                $this->crud->addClause('whereDate', 'created_at', '=', $value);
            });
        */
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
            'name' => 'title',
            'label' => trans('icommerce::common.title'),
        ]);
        $this->crud->addColumn([
            'label' => 'Slug',
            'name' => 'slug',
        ]);

        $this->crud->addColumn([
            'name' => 'parent_id',
            'label' => trans('icommerce::common.parent'),
            'type' => 'select',
            'entity' => 'parent',
            'attribute' => 'title',
            'model' => 'Modules\Icommerce\Entities\Category',
            'defaultvalue' => '0'
        ]);


        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => trans('icommerce::common.created_at'),
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'title',
            'label' => trans('icommerce::common.title'),
            'viewposition' => 'left'

        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => 'Slug',
            'type' => 'text',
            'viewposition' => 'left'

        ]);

        $this->crud->addField([
            'name' => 'description',
            'label' => trans('icommerce::common.description'),
            'type' => 'wysiwyg',
            'viewposition' => 'left'

        ]);

        $this->crud->addField([
            'name' => 'parent_id',
            'label' => trans('icommerce::common.parent'),
            'type' => 'select',
            'entity' => 'parent',
            'attribute' => 'title',
            'model' => 'Modules\Icommerce\Entities\Category',
            'viewposition' => 'right',
            'emptyvalue' => 0
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
            'viewposition' => 'right',
        ]);

        $this->crud->addField([
            'name' => 'showmenu',
            'label' => trans('icommerce::categories.table.showmenu'),
            'type' => 'checkbox',
            'viewposition' => 'right',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-11 pull-right'
            ],
            'fake' => true,
            'store_in' => 'options',
            'viewposition' => 'right',

        ]);

    }

    public function setup()
    {
        parent::setup();

        $permissions = ['index', 'create', 'edit', 'destroy'];
        $allowpermissions = ['show'];
        foreach ($permissions as $permission) {

            if ($this->auth->hasAccess("icommerce.categories.$permission")) {
                if ($permission == 'index') $permission = 'list';
                if ($permission == 'edit') $permission = 'update';
                if ($permission == 'destroy') $permission = 'delete';
                $allowpermissions[] = $permission;
            }

            $allowpermissions[] = 'reorder';

        }
        $this->crud->access = $allowpermissions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  IcommerceRequest $request
     * @return Response
     */
    public function store(IcommerceRequest $request)
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
        $request["mainimage"] = "assets/icommerce/category/default.jpg";


        // insert item in the db
        $item = $this->crud->create($request->except(['save_action', '_token', '_method']));
        $this->data['entry'] = $this->crud->entry = $item;


        //Let's save the image for the post.
        if (!empty($requestimage && !empty($item->id))) {
            $mainimage = $this->saveImage($requestimage, "assets/icommerce/category/" . $item->id . ".jpg");

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
        Cache::forget('headerCategories');
        return $this->performSaveAction($item->getKey());

    }

    /**
     * Save Image.
     *
     * @param  Value
     * @param  Destination
     * @return Response
     */
    public function saveImage($value, $destination_path)
    {

        $disk = "publicmedia";

        //Defined return.
        if (ends_with($value, '.jpg')) {
            return $value;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image')) {
            // 0. Make the image
            $image = \Image::make($value);
            // resize and prevent possible upsizing

            $image->resize(config('asgard.iblog.config.imagesize.width'), config('asgard.iblog.config.imagesize.height'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            if (config('asgard.iblog.config.watermark.activated')) {
                $image->insert(config('asgard.iblog.config.watermark.url'), config('asgard.iblog.config.watermark.position'), config('asgard.iblog.config.watermark.x'), config('asgard.iblog.config.watermark.y'));
            }
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path, $image->stream('jpg', '80'));


            // Save Thumbs
            \Storage::disk($disk)->put(
                str_replace('.jpg', '_mediumThumb.jpg', $destination_path),
                $image->fit(config('asgard.iblog.config.mediumthumbsize.width'), config('asgard.iblog.config.mediumthumbsize.height'))->stream('jpg', '80')
            );

            \Storage::disk($disk)->put(
                str_replace('.jpg', '_smallThumb.jpg', $destination_path),
                $image->fit(config('asgard.iblog.config.smallthumbsize.width'), config('asgard.iblog.config.smallthumbsize.height'))->stream('jpg', '80')
            );

            // 3. Return the path
            return $destination_path;
        }

        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($destination_path);

            // set null in the database column
            return null;
        }


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Category $category
     * @param  UpdateCategoryRequest $request
     * @return Response
     */
    public function update(IcommerceRequest $request)
    {

        if (!empty($request['mainimage']) && !empty($request['id'])) {
            $request['mainimage'] = $this->saveImage($request['mainimage'], "assets/icommerce/category/" . $request['id'] . ".jpg");
        }
        return parent::updateCrud($request);

    }


    /**
     * Filter Options - Ajax Select 2
     *
     * @param  Category $title
     * @return Response
     */
    public function parentOptions()
    {

        $term = $this->request->input('term');
        $options = Category::where('title', 'like', '%' . $term . '%')->get();
        return $options->pluck('title', 'id');

    }


}
