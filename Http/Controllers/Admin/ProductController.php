<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Entities\Product_Option;
use Modules\Icommerce\Entities\Product_Option_Value;
use Modules\Icommerce\Entities\Status;
use Modules\Icommerce\Entities\Stock_Status as StockStatus;
use Modules\Icommerce\Entities\Tag;
use Modules\Icommerce\Http\Requests\ProductRequest;
use Modules\Icommerce\Jobs\BulkloadCategory;
use Modules\Icommerce\Jobs\BulkloadManufacturer;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\Option_ValueRepository as OptionValueRepository;
use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Icommerce\Repositories\Product_Option_ValueRepository as ProductOptionValueRepository;
use Modules\Icommerce\Repositories\Product_OptionRepository as ProductOptionRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\TagRepository;
use Modules\User\Contracts\Authentication;
use Modules\User\Repositories\UserRepository;
use Yajra\Datatables\Datatables;


class ProductController extends AdminBaseController
{

    /**
     * @var ProductRepository
     */

    private $product;
    private $user;
    protected $auth;
    private $entity;
    private $status;
    private $category;
    private $manufacturer;
    private $tag;
    private $option;
    private $optionValues;
    private $productOption;
    private $productOptionValue;

    public function __construct(ProductRepository $product, Authentication $auth, UserRepository $user, Product $entity, Status $status, CategoryRepository $category, StockStatus $stockstatus, ManufacturerRepository $manufacturer, TagRepository $tag, OptionRepository $option, OptionValueRepository $optionValues, ProductOptionRepository $productOption, ProductOptionValueRepository $productOptionValue)

    {
        parent::__construct();
        $this->product = $product;
        $this->entity = $entity;
        $this->status = $status;
        $this->auth = $auth;
        $this->user = $user;
        $this->category = $category;
        $this->stockstatus = $stockstatus;
        $this->manufacturer = $manufacturer;
        $this->tag = $tag;
        $this->option = $option;
        $this->optionValues = $optionValues;
        $this->productOption = $productOption;
        $this->productOptionValue = $productOptionValue;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

        $entity = $this->entity;
        return view('icommerce::admin.products.index', compact('entity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    public function create()
    {
        $entity = $this->entity;
        $status = $this->status;
        $categories = $this->category->allcat();
        $stockstatus = $this->stockstatus;
        $manufacturers = $this->manufacturer->all();
        $tags = $this->tag->all();
        $options = $this->option->all();
        $optionValues = $this->optionValues->all();

        return view('icommerce::admin.products.create', compact('entity', 'status', 'categories', 'stockstatus', 'manufacturers', 'tags', 'options', 'optionValues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {

        $user = $this->auth->user();
        $request->merge(['user_id' => $user->id]);
        $requestimage = $request["mainimage"];

        if (empty($request->date_available)) {
            $request["date_available"] = date("Y-m-d");
        }

        if (isset($request->related_ids) && !empty($request->related_ids)) {
            $request["related_ids"] = json_encode($request->related_ids);
        }

        $product = $this->product->create($request->except(['_token', 'categories', 'mainimage', 'tags', 'dquantity', 'dprice', 'ddatestart', 'ddateend', 'optionsPSave', 'selOptions', 'vrequired', 'vtext', 'vtextarea', 'tableSOption', 'tableQuantity', 'tableSustract', 'tablePricePrefix', 'tablePrice', 'tableWeightPrefix', 'tableWeight', 'pfile', 'subpTitle', 'subpSku', 'subpPrice', 'subpQuantity', 'subpImage', 'subpWeight', 'hiddenSubImg', 'MAX_FILE_SIZE', 'gallery', 'meta_title', 'meta_description', 'meta_keyword']));

        if ($product) {
            if (isset($request->categories)) {
                $product->categories()->sync($request->categories);
            }

            if (isset($request->tags)) {
                $request['tags'] = $this->addTags($request['tags']);
                $product->tags()->sync($request->tags);
            }
        }

        // Imagen
        if (!empty($requestimage && !empty($product->id))) {
            $mainimage = $this->saveImage($requestimage, "assets/icommerce/product/" . $product->id . ".jpg");

            $options = $product->options;
            $options["mainimage"] = $mainimage;
            $product->options = json_encode($options);
            $product->save();
        }

        // Discount
        if (!empty($request->dquantity)) {
            $param = array(
                'quantity' => $request->dquantity,
                'priority' => 1,
                'price' => $request->dprice,
                'datestart' => $request->ddatestart,
                'dateend' => $request->ddateend
            );
            $product->product_discounts()->create($param);
        }

        // Options
        if (isset($request->optionsPSave) && !empty($product->id)) {
            $optionsProductS = json_decode($request->optionsPSave);
            if (!empty($optionsProductS)) {

                foreach ($optionsProductS as $key => $op) {

                    $param = array(
                        'product_id' => $product->id,
                        'option_id' => $op->option_id,
                        'value' => $op->value,
                        'required' => $op->required
                    );

                    $product_option = $this->productOption->create($param);
                    foreach ($op->optionValues as $key => $value) {

                        $param2 = array(
                            'product_option_id' => $product_option->id,
                            'product_id' => $product->id,
                            'option_id' => $value->option_id,
                            'option_value_id' => $value->option_value_id,
                            'quantity' => $value->quantity,
                            'substract' => $value->substract,
                            'price' => $value->price,
                            'price_prefix' => $value->price_prefix,
                            'points' => $value->points,
                            'points_prefix' => $value->points_prefix,
                            'weight' => $value->weight,
                            'weight_prefix' => $value->weight_prefix
                        );

                        $this->productOptionValue->create($param2);

                    }


                }


            }

        }

        // File
        if ($request->hasFile('pfile') && $request->file('pfile')->isValid()) {
            $filePath = $this->saveFile($request->file('pfile'), $product->id);
            if ($filePath != null) {
                $options = (array)$product->options;
                $options["mainfile"] = $filePath;
                $product->options = json_encode($options);
                $product->save();
            }
        }

        // Sub Products
        if (!empty($product->id) && isset($request->subpTitle)) {

            $vsubPTitles = $request->subpTitle;
            $vsubPSkus = $request->subpSku;
            $vsubPrices = $request->subpPrice;
            $vsubPQuantities = $request->subpQuantity;
            $vsubPImages = $request->hiddenSubImg;
            $vsubPWeights = $request->subpWeight;

            foreach ($vsubPTitles as $index => $val) {

                $this->createSubProduct($product, $vsubPTitles[$index], $vsubPSkus[$index], $vsubPQuantities[$index], $vsubPrices[$index], $vsubPImages[$index], $vsubPWeights[$index]);

            }

        }

        // Gallery
        if (!empty($request['gallery'] && !empty($product->id))) {
            if (count(\Storage::disk('publicmedia')->files('assets/icommerce/product/gallery/' . $request['gallery']))) {
                \File::makeDirectory('assets/icommerce/product/gallery/' . $product->id);
                $success = rename('assets/icommerce/product/gallery/' . $request['gallery'], 'assets/icommerce/product/gallery/' . $product->id);
            }
        }

        // Metas
        if (!empty($product->id)) {
            $this->saveMetas($request, $product);
        }

        return redirect()->route('admin.icommerce.product.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::products.title.products')]));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product $product
     * @return Response
     */

    public function edit(Product $product, Request $request)
    {

        $entity = $this->entity;
        $status = $this->status;
        $categories = $this->category->allcat();
        $stockstatus = $this->stockstatus;
        $manufacturers = $this->manufacturer->all();
        $tags = $this->tag->all();
        $options = $this->option->all();
        $optionValues = $this->optionValues->all();

        return view('icommerce::admin.products.edit', compact('product', 'entity', 'request', 'status', 'categories', 'stockstatus', 'manufacturers', 'tags', 'options', 'optionValues'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product $product
     * @param  UpdateProductRequest $request
     * @return Response
     */

    public function update(Product $product, ProductRequest $request)
    {

        $requestimage = $request["mainimage"];

        if (empty($request->date_available)) {
            $request["date_available"] = date("Y-m-d");
        }

        if (isset($request->related_ids)) {
            $request["related_ids"] = json_encode($request->related_ids);
        } else {
            $request["related_ids"] = null;
        }

        $product = $this->product->update($product, $request->except(['_token', '_method', 'categories', 'mainimage', 'tags', 'dquantity', 'dprice', 'ddatestart', 'ddateend', 'optionsPSave', 'selOptions', 'vrequired', 'vtext', 'vtextarea', 'tableSOption', 'tableQuantity', 'tableSustract', 'tablePricePrefix', 'tablePrice', 'tableWeightPrefix', 'tableWeight', 'povDelete', 'poDelete', 'pfile', 'subpTitle', 'subpSku', 'subpPrice', 'subpQuantity', 'subpImage', 'subpWeight', 'hiddenSubImg', 'subpId', 'hiddenFileDel', 'MAX_FILE_SIZE', 'meta_title', 'meta_description', 'meta_keyword']));

        if ($product) {
            if (isset($request->categories)) {
                $product->categories()->sync($request->categories);
            } else {
                $product->categories()->detach();

            }
            if (isset($request->tags)) {
                $request['tags'] = $this->addTags($request['tags']);
                $product->tags()->sync($request->tags);
            } else {
                $product->tags()->detach();
            }
        }

        // Imagen
        if (!empty($product->id)) {
            if (($requestimage == NULL) || (!empty($requestimage))) {
                $mainimage = $this->saveImage($requestimage, "assets/icommerce/product/" . $product->id . ".jpg");
                $options = (array)$product->options;
                $options["mainimage"] = $mainimage;
                $product->options = json_encode($options);
                $product->save();
            }
        }

        // Discount
        if (!empty($request->dquantity)) {
            $param = array(
                'quantity' => $request->dquantity,
                'priority' => 1,
                'price' => $request->dprice,
                'datestart' => $request->ddatestart,
                'dateend' => $request->ddateend
            );
            $update = $product->product_discounts()->update($param);

            if (!$update) {
                $product->product_discounts()->create($param);
            }

        } else {
            $product->product_discounts()->delete();
        }

        // Create, Update, Delete (Product Option, Product Option Values)
        if (isset($request->optionsPSave) && !empty($product->id)) {

            $optionsProductS = json_decode($request->optionsPSave);
            $alldelete = 0;

            if (!empty($optionsProductS)) {

                // Seach Product Option
                foreach ($optionsProductS as $key => $op) {
                    // Update
                    if (!empty($op->pivot_id)) {

                        $product_option = Product_Option::where("id", $op->pivot_id)->update(
                            ['value' => $op->value,
                                'required' => $op->required
                            ]);
                        $product_option_id = $op->pivot_id;
                    } else {
                        //Create
                        $param = array(
                            'product_id' => $product->id,
                            'option_id' => $op->option_id,
                            'value' => $op->value,
                            'required' => $op->required
                        );
                        $product_option = $this->productOption->create($param);
                        $product_option_id = $product_option->id;
                    }

                    // Product Option Values
                    foreach ($op->optionValues as $key => $value) {

                        $param3 = [
                            'option_value_id' => $value->option_value_id,
                            'quantity' => $value->quantity,
                            'substract' => $value->substract,
                            'price' => $value->price,
                            'price_prefix' => $value->price_prefix,
                            'points' => $value->points,
                            'points_prefix' => $value->points_prefix,
                            'weight' => $value->weight,
                            'weight_prefix' => $value->weight_prefix

                        ];
                        // Update
                        if (!empty($value->pov_id)) {
                            Product_Option_Value::where("id", $value->pov_id)->update($param3);
                        } else {

                            // Create
                            $param2 = array(
                                'product_option_id' => $product_option_id,
                                'product_id' => $product->id,
                                'option_id' => $value->option_id,
                                'option_value_id' => $value->option_value_id,
                                'quantity' => $value->quantity,
                                'substract' => $value->substract,
                                'price' => $value->price,
                                'price_prefix' => $value->price_prefix,
                                'points' => $value->points,
                                'points_prefix' => $value->points_prefix,
                                'weight' => $value->weight,
                                'weight_prefix' => $value->weight_prefix
                            );
                            $this->productOptionValue->create($param2);
                        }
                    }
                }

            } else {

                // Delete All 
                $product->product_option_values()->delete();
                $product->optionsv()->detach();
                $alldelete = 1;

            }

            if ($alldelete == 0) {

                // Product Options to Delete with Product Options Values
                if (isset($request->poDelete)) {
                    $poToDelete = json_decode($request->poDelete);
                    if (!empty($poToDelete)) {
                        foreach ($poToDelete as $key => $podel) {
                            Product_Option_Value::where("product_option_id", $podel->id)->delete();
                            Product_Option::where("id", $podel->id)->delete();
                        }
                    }
                }

                // Product Options Value to Delete
                if (isset($request->povDelete)) {
                    $povToDelete = json_decode($request->povDelete);
                    if (!empty($povToDelete)) {
                        foreach ($povToDelete as $key => $povdel) {
                            Product_Option_Value::where("id", $povdel->id)->delete();
                        }
                    }
                }
            }
        }

        // File Delete
        if (isset($request->hiddenFileDel) && $request->hiddenFileDel == "1") {

            $options = (array)$product->options;
            $FileDel = $this->deleteFile($options["mainfile"]);

            if ($FileDel) {
                $options["mainfile"] = null;
                $product->options = $options;
                $product->save();
            }
        }

