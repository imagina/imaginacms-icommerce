<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Shipping_Courier;
use Modules\Icommerce\Http\Requests\CreateShipping_CourierRequest;
use Modules\Icommerce\Http\Requests\UpdateShipping_CourierRequest;
use Modules\Icommerce\Repositories\Shipping_CourierRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\User\Contracts\Authentication;
use Modules\Icommerce\Http\Requests\ShippingCourierRequest;

class Shipping_CourierController extends BcrudController
{
    /**
     * @var Shipping_CourierRepository
     */
    private $shipping_courier;
    private $auth;

    public function __construct(Authentication $auth)
    {
        parent::__construct();
        $this->auth = $auth;
        //$this->shipping_courier = $shipping_courier;

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Modules\Icommerce\Entities\Shipping_Courier');
        $this->crud->setRoute('backend/icommerce/shipping_courier');
        $this->crud->setEntityNameStrings(trans('icommerce::shipping_couriers.single'), trans('icommerce::shipping_couriers.plural'));
        $this->access = [];
        $this->crud->enableAjaxTable();
        $this->crud->orderBy('created_at', 'DESC');
        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('code', 2);
        $this->crud->removeButton( 'delete' );

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'code',
            'label' => trans('icommerce::shipping_couriers.table.code'),
        ]);


        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('icommerce::common.title'),
        ]);

        $this->crud->addColumn([
            'name' => 'status',
            'label' => trans('icommerce::common.status_text'),
            'type' => 'boolean',
            'options' => [
                0 => trans('icommerce::status.disabled'),
                1 => trans('icommerce::status.enabled')
            ],
        ]);

        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => trans('icommerce::common.created_at'),
        ]);


        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'code',
            'label' => trans('icommerce::shipping_couriers.table.code'),
            'type' => 'text',
            'viewposition' => 'left'
        ]);

        $this->crud->addField([
            'name' => 'name',
            'label' => trans('icommerce::common.title'),
            'type' => 'text',
            'viewposition' => 'left'
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateShipping_CourierRequest $request
     * @return Response
     */
    public function store(ShippingCourierRequest $request)
    {
        return parent::storeCrud($request);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  Shipping_Courier $shipping_courier
     * @param  UpdateShipping_CourierRequest $request
     * @return Response
     */
    public function update(Shipping_Courier $shipping_courier, ShippingCourierRequest $request)
    {
        return parent::updateCrud($request);
        
    }

    public function setup()
    {
        parent::setup();

        $permissions = ['index', 'create', 'edit', 'destroy'];
        $allowpermissions = ['show'];
        foreach($permissions as $permission) {

            if($this->auth->hasAccess("icommerce.shipping_couriers.$permission")) {
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
