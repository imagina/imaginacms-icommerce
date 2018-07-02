<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Comment;
use Modules\Icommerce\Http\Requests\CommentRequest;
use Modules\Icommerce\Repositories\CommentRepository;

use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\User\Contracts\Authentication;

class CommentController extends BcrudController
{
    
   

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
        $this->crud->setModel('Modules\Icommerce\Entities\Comment');
        $this->crud->setRoute('backend/icommerce/comment');
        $this->crud->setEntityNameStrings(trans('icommerce::comments.single'), trans('icommerce::comments.plural'));
        $this->access = [];

        $this->crud->enableAjaxTable();
        $this->crud->orderBy('created_at', 'DESC');
        $this->crud->limit(100);
        $this->crud->removeButton('preview');

         /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
        ]);

        $this->crud->addColumn([
            'name' => 'product_id',
            'label' => trans('icommerce::products.single'),
            'type' => 'select',
            'attribute' => 'title',
            'entity' => 'product',
            'model' => "Modules\\Icommerce\\Entities\\Product",
        ]);

        $this->crud->addColumn([
            'label' => trans('iblog::common.author'),
            'name' => 'user_id',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'email',
            'model' => "Modules\\User\\Entities\\{$driver}\\User"
        ]);

        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => trans('icommerce::common.created_at')
        ]);


        $this->crud->addField([
            'name' => 'product_id',
            'label' => trans('icommerce::products.single'),
            'type' => 'select',
            'attribute' => 'title',
            'entity' => 'product',
            'attributes' => ['disabled' => 'disable'],
            'model' => "Modules\\Icommerce\\Entities\\Product",
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'label' => trans('iblog::common.author'),
            'name' => 'user_id',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'email',
            'model' => "Modules\\User\\Entities\\{$driver}\\User",
            'attributes' => ['disabled' => 'disable'],
            'viewposition' => 'right',
        ]);

        $this->crud->addField([
            'name' => 'content',
            'label' => trans('icommerce::common.content'),
            'type' => 'textarea',
            'attributes' => ['rows' => '10','readonly' => 'readonly'],
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'name' => 'created_at',
            'label' => trans('icommerce::common.created_at'),
            'type' => 'date',
            'attributes' => ['readonly' => 'readonly'],
            'viewposition' => 'right',
        ]);

        $this->crud->addField([
            'name' => 'status',
            'label' => trans('icommerce::common.status_text'),
            'type' => 'radio',
            'options' => [
                0 => trans('icommerce::status.disabled'),
                1 => trans('icommerce::status.enabled')
            ],
            'viewposition' => 'right',
        ]);


    }

    public function setup()
    {
        parent::setup();

        $permissions = ['index', 'edit', 'destroy'];
        $allowpermissions = ['show'];
        foreach($permissions as $permission) {

            if($this->auth->hasAccess("icommerce.comments.$permission")) {
                if($permission=='index') $permission = 'list';
                if($permission=='edit') $permission = 'update';
                if($permission=='destroy') $permission = 'delete';
                $allowpermissions[] = $permission;
            }

        }

        $this->crud->access = $allowpermissions;
    }

    public function store(CommentRequest $request)
    {
        return parent::storeCrud();
    }

   
    public function update(CommentRequest $request)
    {
        return parent::updateCrud($request);
    }
   


   
}