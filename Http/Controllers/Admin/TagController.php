<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Tag;
use Modules\Icommerce\Http\Requests\CreateTagRequest;
use Modules\Icommerce\Http\Requests\UpdateTagRequest;
use Modules\Icommerce\Http\Requests\TagRequest;
use Modules\Icommerce\Repositories\TagRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\User\Contracts\Authentication;

class TagController extends BcrudController
{
    /**
     * @var TagRepository
     */
    private $tag;
    private $auth;

    public function __construct(Authentication $auth)
    {
        parent::__construct();

        //$this->tag = $tag;
        $this->auth = $auth;

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Modules\Icommerce\Entities\Tag');
        $this->crud->setRoute('backend/icommerce/tag');
        $this->crud->setEntityNameStrings(trans('icommerce::tags.single'), trans('icommerce::tags.plural'));
        $this->access = [];

        $this->crud->enableAjaxTable();
        $this->crud->orderBy('created_at', 'DESC');
        $this->crud->limit(100);

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
            'name' => 'created_at',
            'label' => trans('icommerce::common.created_at'),
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'title',
            'label' => trans('icommerce::common.title'),
        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => 'Slug',
            'type' => 'text',
        ]);

    }

    public function setup()
    {
        parent::setup();

        $permissions = ['index', 'create', 'edit', 'destroy'];
        $allowpermissions = ['show'];
        foreach($permissions as $permission) {

            if($this->auth->hasAccess("icommerce.tags.$permission")) {
                if($permission=='index') $permission = 'list';
                if($permission=='edit') $permission = 'update';
                if($permission=='destroy') $permission = 'delete';
                $allowpermissions[] = $permission;
            }

        }

        $this->crud->access = $allowpermissions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function store(TagRequest $request)
    {
        return parent::storeCrud();
    }

   
    public function update(TagRequest $request)
    {
        return parent::updateCrud($request);
    }


}