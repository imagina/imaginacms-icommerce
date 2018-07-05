<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Icommerce\Entities\Coupon;

use Modules\Icommerce\Http\Requests\CouponRequest;

use Modules\Icommerce\Repositories\CouponRepository;

use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\User\Contracts\Authentication;
use Illuminate\Contracts\Foundation\Application;

use Modules\Setting\Contracts\Setting;

class CouponController extends BcrudController
{
    /**
     * @var CouponRepository
     */
    private $coupon;
    private $auth;
    private $setting;

    public function __construct(CouponRepository $coupon,Authentication $auth, Setting $setting)
    {
        parent::__construct();

        $this->coupon = $coupon;
        $this->auth = $auth;
        $driver = config('asgard.user.config.driver');
        $this->setting = $setting;

         /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Modules\Icommerce\Entities\Coupon');
        $this->crud->setRoute('backend/icommerce/coupon');
        $this->crud->setEntityNameStrings(trans('icommerce::coupons.single'), trans('icommerce::coupons.plural'));
        $this->access = [];
        $this->crud->enableAjaxTable();
        $this->crud->orderBy('created_at', 'DESC');
        $this->crud->limit(100);
        $this->crud->removeButton( 'delete' );


        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
        ]);

        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('icommerce::common.title'),
        ]);

        $this->crud->addColumn([
            'name' => 'code',
            'label' => trans('icommerce::coupons.table.code'),
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
            'name' => 'uses_total',
            'label' => trans('icommerce::coupons.table.uses_total'),
        ]);

        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => trans('icommerce::common.created_at'),
        ]);

        // ------ CRUD FIELDS

        $this->crud->addField([
            'name' => 'name',
            'label' => trans('icommerce::common.title'),
            'type' => 'text',
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'name' => 'code',
            'label' => trans('icommerce::coupons.table.code'),
            'type' => 'text',
            'default' => $this->addCouponCode(),
            'attributes' => ['readonly' => 'readonly'],
            'viewposition' => 'left',
        ]);

        $this->crud->addField([ 
            'name' => 'type',
            'label' => trans('icommerce::coupons.table.type'),
            'type' => 'select_from_array',
            'options' => [
                'p' => trans('icommerce::coupons.table.percentage'),
                'f' => trans('icommerce::coupons.table.fixed')
            ],
            'allows_null' => false,
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'name' => 'discount',
            'label' => trans('icommerce::coupons.table.discount'),
            'type' => 'number',
            'attributes' => ["step" => "two"],
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'name' => 'logged',
            'label' => trans('icommerce::coupons.table.logged'),
            'type' => 'select_from_array',
            'options' => [0 => trans('icommerce::coupons.table.no'), 1 => trans('icommerce::coupons.table.yes')],
            'allows_null' => false,
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'name' => 'shipping',
            'label' => trans('icommerce::coupons.table.shipping'),
            'type' => 'select_from_array',
            'options' => [0 => trans('icommerce::coupons.table.no'), 1 => trans('icommerce::coupons.table.yes')],
            'allows_null' => false,
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'name' => 'total',
            'label' => trans('icommerce::coupons.table.total'),
            'type' => 'number',
            'attributes' => [
                "step" => "any"
            ],
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'name' => 'uses_total',
            'label' => trans('icommerce::coupons.table.uses_total'),
            'type' => 'number',
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'name' => 'datestart',
            'label' => trans('icommerce::coupons.table.datestart'),
            'type' => 'date',
            'viewposition' => 'right',
        ]);

         $this->crud->addField([
            'name' => 'dateend',
            'label' => trans('icommerce::coupons.table.dateend'),
            'type' => 'date',
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

        /*
        $this->crud->addField([
            'label' => "Productos", // Table column heading
            'type' => "select2_from_ajax_multiple",
            'name' => 'product_id', // the column that contains the ID of that connected entity
            'entity' => 'products', // the method that defines the relationship in your Model
            'attribute' => "title", // foreign key attribute that is shown to user
            'model' => "Modules\\Icommerce\\Entities\\Product", // foreign key model
            'data_source' => url("api/product"), // url to controller search function (with /{id} should return model)
            'placeholder' => "Seleccione producto", // placeholder for the select
            'minimum_input_length' => 2, // minimum characters to type before querying results
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            'viewposition' => 'right',
        ]);
        */


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCouponRequest $request
     * @return Response
     */
    
    /*
    public function index(){

        $test = "mjSt-Sw4o-IGo4";
        $test = "5dht-jxRl-TJ7P";

        $code = strip_tags(trim($test));

        $result = $this->coupon->findByCode($code);

        dd($result);
        exit();
    }
    */
   

    public function store(CouponRequest $request)
    {

        return parent::storeCrud($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Coupon $coupon
     * @param  UpdateCouponRequest $request
     * @return Response
     */
    public function update(Coupon $coupon, CouponRequest $request)
    {
        
        return parent::updateCrud($request);
    }

    /**
     * Show
     *
     * @param 
     * @param  
     * @return 
     */
    public function setup()
    {
        parent::setup();

        $permissions = ['index', 'create', 'edit', 'destroy'];
        $allowpermissions = ['show'];
        foreach($permissions as $permission) {

            if($this->auth->hasAccess("icommerce.coupons.$permission")) {
                if($permission=='index') $permission = 'list';
                if($permission=='edit') $permission = 'update';
                if($permission=='destroy') $permission = 'delete';
                $allowpermissions[] = $permission;
            }

        }
        $this->crud->access = $allowpermissions;
    }


     /**
     * Show
     *
     * @param 
     * @param  
     * @return 
     */
    public function addCouponCode(){

        $code = "";

        $couponFormat = $this->setting->get('icommerce::coupon-format');
        $codePrefix = $this->setting->get('icommerce::code-prefix');
        $codeSufix = $this->setting->get('icommerce::code-sufix');
        
        $uppercase = ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];

        $lowercase = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm'];

        $numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        $characters = [];

        if(empty($couponFormat))
            $couponFormat = "alphabetic";

        if($couponFormat=="alphabetic"){
            $characters = array_merge($characters, $lowercase, $uppercase);  
        }

        if($couponFormat=="numeric"){
            $characters = array_merge($characters, $numbers);  
        }

        if($couponFormat=="alphanumeric"){
            $characters = array_merge($characters, $numbers, $lowercase, $uppercase);  
        }

        // Asumiendo que se pudiera repetir el codigo que se genera
        //=============================================
        $result = 1;

        while($result==1){
            $code = $this->generaterCouponCode($characters);
            $result = Coupon::where("code",$code)->count();
        }
        //=============================================

       
        if(!empty($codePrefix))
            $codePrefix = $codePrefix ."-";

        if(!empty($codeSufix))
            $codeSufix = "-".$codeSufix;

        return $codePrefix.$code.$codeSufix;

    }

     /**
     * Show
     *
     * @param 
     * @param  
     * @return 
     */
    public function generaterCouponCode($characters){

        $cont = 0;
        $contdash = 0;
        $code = "";

        $codeLENGTH = $this->setting->get('icommerce::code-length');
        $dashEvery = $this->setting->get('icommerce::dash-every');

        while($cont < $codeLENGTH){

            $code .= $characters[mt_rand(0, count($characters) - 1)];

            $contdash++;
            $cont++;

            if($contdash==$dashEvery && $cont<$codeLENGTH){
                $code .= "-";
                $contdash = 0;
            }

        }

        return $code;

    }
   

}
