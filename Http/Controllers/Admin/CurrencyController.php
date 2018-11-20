<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Currency;

use Modules\Icommerce\Repositories\CurrencyRepository;

use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\User\Contracts\Authentication;
use Modules\Icommerce\Http\Requests\CurrencyRequest;

class CurrencyController extends BcrudController
{
    /**
     * @var CurrencyRepository
     */
    private $currency;
    private $auth;

    public function __construct(CurrencyRepository $currency, Authentication $auth)
    {
        parent::__construct();
        $this->auth = $auth;
        $this->currency = $currency;

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Modules\Icommerce\Entities\Currency');
        $this->crud->setRoute('backend/icommerce/currency');
        $this->crud->setEntityNameStrings(trans('icommerce::currencies.single'), trans('icommerce::currencies.plural'));
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
            'name' => 'title',
            'label' => trans('icommerce::common.title'),
        ]);

        $this->crud->addColumn([
            'name' => 'code',
            'label' => trans('icommerce::currencies.table.code'),
        ]);

         $this->crud->addColumn([
            'name' => 'value',
            'label' => trans('icommerce::currencies.table.value'),
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

       
        // ------ CRUD FIELDS

        $this->crud->addField([
            'name' => 'title',
            'label' => trans('icommerce::common.title'),
            'type' => 'text',
            'viewposition' => 'left'
        ]);

       
        $this->crud->addField([
            'name' => 'code',
            'label' => trans('icommerce::currencies.table.code'),
            'type' => 'text',
            'viewposition' => 'left'
        ]);

       
        $this->crud->addField([
            'name' => 'symbol_left',
            'label' => trans('icommerce::currencies.table.symbol_left'),
            'type' => 'text',
            'viewposition' => 'left'
        ]);

        $this->crud->addField([
            'name' => 'symbol_right',
            'label' => trans('icommerce::currencies.table.symbol_right'),
            'type' => 'text',
            'viewposition' => 'left'
        ]);

        $this->crud->addField([
            'name' => 'decimal_place',
            'label' => trans('icommerce::currencies.table.decimal_place'),
            'type' => 'text',
            'viewposition' => 'left'
        ]);
        
        $this->crud->addField([
            'name' => 'value',
            'label' => trans('icommerce::currencies.table.value'),
            'type' => 'number',
            'attributes' => ["step" => "any"],
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
     * @param  CurrencyRequest $request
     * @return Response
     */
    public function store(CurrencyRequest $request)
    {
        return parent::storeCrud($request);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  Currency $currency
     * @param  CurrencyRequest $request
     * @return Response
     */
    public function update(Currency $currency, CurrencyRequest $request)
    {
        return parent::updateCrud($request);
    }



    public function setup()
    {
        parent::setup();

        $permissions = ['index', 'create', 'edit', 'destroy'];
        $allowpermissions = ['show'];
        foreach($permissions as $permission) {

            if($this->auth->hasAccess("icommerce.currencies.$permission")) {
                if($permission=='index') $permission = 'list';
                if($permission=='edit') $permission = 'update';
                if($permission=='destroy') $permission = 'delete';
                $allowpermissions[] = $permission;
            }

        }
        $this->crud->access = $allowpermissions;
    }

    
   
}