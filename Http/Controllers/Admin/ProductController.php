<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Entities\Status;
use Modules\Icommerce\Http\Requests\ProductRequest;
use Modules\Icommerce\Imports\IcommerceImport;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends AdminBaseController
{
    /**
     * @var ProductRepository
     */
    private $product;
    private $auth;
    private $status;
    private $entity;
    private $category;
    private $manufacturer;
    private $option;


    public function __construct(ProductRepository $product,Product $entity, Status $status, CategoryRepository $category,  ManufacturerRepository $manufacturer, OptionRepository $option)
    {
        parent::__construct();

        $this->product = $product;
        $this->auth = app(Authentication::class);
        $this->entity = $entity;
        $this->status = $status;
        $this->category = $category;
        $this->manufacturer = $manufacturer;
        $this->option = $option;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('icommerce::admin.products.index');
    }

    public function indeximport()
    {
        return view('icommerce::admin.products.bulkload.index');
    }

    public function importProducts(Request $request){
        $msg="";
        try {
            $data = ['folderpaht' => $request->folderpaht, 'user_id' => $this->auth->user()->id, 'Locale'=>$request->Locale];
            $data_excel = Excel::import(new IcommerceImport($this->product,$this->category,$this->manufacturer,$data), $request->importfile);
            $msg=trans('icommerce::products.bulkload.success migrate from product');
            return redirect()->route('admin.icommerce.store.index')
                ->withSuccess($msg);
        } catch (Exception $e) {
            $msg  =  trans('icommerce::products.bulkload.error in migrate from page');
            return redirect()->route('admin.icommerce.store.index')
                ->withError($msg);
        }
    }//importProducts()

}
