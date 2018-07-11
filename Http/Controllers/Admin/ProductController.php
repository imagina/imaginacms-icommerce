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

        // File Add / Update
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
            $vsubPIds = $request->subpId;
            $vsubPTitles = $request->subpTitle;
            $vsubPSkus = $request->subpSku;
            $vsubPrices = $request->subpPrice;
            $vsubPQuantities = $request->subpQuantity;
            $vsubPImages = $request->hiddenSubImg;
            $vsubPWeights = $request->subpWeight;

            foreach ($vsubPTitles as $index => $val) {

                // Update
                if (!empty($vsubPIds[$index])) {

                    $subProduct = $this->product->find($vsubPIds[$index]);

                    $subProduct->title = $vsubPTitles[$index]; //Propio
                    $subProduct->slug = ""; //Propio
                    $subProduct->sku = $vsubPSkus[$index]; //Propio
                    $subProduct->price = $vsubPrices[$index]; //Propio
                    $subProduct->quantity = $vsubPQuantities[$index]; //Propio
                    $subProduct->weight = $vsubPWeights[$index]; //Propio
                    $subProduct->description = $product->description;
                    $subProduct->status = $product->status;
                    $subProduct->category_id = $product->category_id;
                    $subProduct->stock_status = $product->stock_status;
                    $subProduct->date_available = $product->date_available;

                    $subProduct->width = $product->width;
                    $subProduct->height = $product->height;
                    $subProduct->length = $product->length;
                    $subProduct->freeshipping = $product->freeshipping;

                    $subProduct->update();

                    if (!empty($vsubPImages[$index]) && !empty($subProduct->id)) {

                        $mainimage = $this->saveImage($vsubPImages[$index], "assets/icommerce/product/" . $subProduct->id . ".jpg");

                        $options = (array)$subProduct->options;
                        $options["mainimage"] = $mainimage;
                        $subProduct->options = json_encode($options);
                        $subProduct->save();
                    }


                } else {
                    //Create
                    $this->createSubProduct($product, $vsubPTitles[$index], $vsubPSkus[$index], $vsubPQuantities[$index], $vsubPrices[$index], $vsubPImages[$index], $vsubPWeights[$index]);

                }

            }


        }

        // Metas
        if (!empty($product->id)) {
            $this->saveMetas($request, $product);
        }

        return redirect()->route('admin.icommerce.product.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::products.title.products')]));

    }

    /**
     * save Image
     *
     * @param  Img $value
     * @param  String $destination_path
     * @return path
     */
    public function saveImage($value, $destination_path)
    {

        $disk = "publicmedia";

        if (starts_with($value, 'http')) {
            $url = url('modules/bcrud/img/default.jpg');
            if ($value == $url) {
                return 'modules/icommerce/img/product/default.jpg';
            } else {
                if (empty(str_replace(url(''), "", $value))) {

                    return 'modules/icommerce/img/product/default.jpg';
                }
                str_replace(url(''), "", $value);
                return str_replace(url(''), "", $value);
            }

        };

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
     * Add tags Product
     *
     * @param  Array tags ids
     * @return Array
     */
    public function addTags($tags)
    {

        $tags = $tags;
        $newtags = Array();
        $lasttagsid = Array();
        $newtagsid = Array();

        if (!empty($tags)) {

            //se recorren todos lostags en busca de alguno nuevo
            foreach ($tags as $tag) {
                //si el tag no existe se agrega al array de de nuevos tags
                if (count(Tag::find($tag)) <= 0) {
                    array_push($newtags, $tag);
                } else {
                    //si el tag existe se agrega en un array de viejos tags
                    array_push($lasttagsid, $tag);
                }

            }

        }

        //se crean todos los tags que no existian

        foreach ($newtags as $newtag) {

            $modeltag = new Tag;

            $modeltag->title = $newtag;

            $modeltag->slug = str_slug($newtag, '-');

            $modeltag->save();

            array_push($newtagsid, $modeltag->id);

        }

        //se modifica el valor tags enviado desde el form uniendolos visjos tags y los tags nuevos

        return array_merge($lasttagsid, $newtagsid);

    }

    /**
     * Save a File
     *
     * @param  File $pfile
     * @param  Int $idProduct
     * @return
     */
    public function saveFile($pfile, $idProduct)
    {

        $disk = 'publicmedia';

        $original_filename = $pfile->getClientOriginalName();
        $extension = $pfile->getClientOriginalExtension();
        $allowedextensions = array('PDF');

        if (!in_array(strtoupper($extension), $allowedextensions)) {
            return null;
        }

        $name = str_slug(str_replace('.' . $extension, '', $original_filename), '-');
        $namefile = $name . '.' . $extension;

        $destination_path = 'assets/icommerce/product/files/' . $idProduct . '/' . $namefile;

        \Storage::disk($disk)->put($destination_path, \File::get($pfile));
        return $destination_path;
    }

    /**
     * Delete a File
     *
     * @param  Strong $destination_path
     * @return $result
     */
    public function deleteFile($destination_path)
    {
        $disk = "publicmedia";
        $result = \Storage::disk($disk)->delete($destination_path);

        return $result;
    }

    /**
     * Create Sub Product.
     *
     * @param  Int $id
     * @return
     */
    public function createSubProduct($product, $title, $sku, $quantity, $price, $image, $weight)
    {

        $subProduct = new Product();
        $subProduct->title = $title; //Propio
        $subProduct->description = $product->description;
        $subProduct->status = $product->status;
        $subProduct->slug = "";//Propio
        $subProduct->summary = "";//Propio
        $subProduct->user_id = $product->user_id;
        $subProduct->category_id = $product->category_id;
        $subProduct->parent_id = $product->id;
        $subProduct->sku = $sku;//Propio
        $subProduct->quantity = $quantity;//Propio
        $subProduct->stock_status = $product->stock_status;
        $subProduct->price = $price;//Propio
        $subProduct->date_available = $product->date_available;
        $subProduct->weight = $weight;//Propio

        $subProduct->width = $product->width;
        $subProduct->height = $product->height;
        $subProduct->length = $product->length;
        $subProduct->freeshipping = $product->freeshipping;

        $subProduct->save();

        if (!empty($image) && !empty($subProduct->id)) {

            $mainimage = $this->saveImage($image, "assets/icommerce/product/" . $subProduct->id . ".jpg");

            $options = $subProduct->options;
            $options["mainimage"] = $mainimage;
            $subProduct->options = json_encode($options);
            $subProduct->save();
        }
    }

    /**
     * Delete Sub Product via Ajax.
     *
     * @param  Product $id
     * @return Response Json
     */
    public function deleteSubproduct($id)
    {


        $response = array();
        $response['status'] = 'error'; //default

        try {
            $subProduct = $this->product->find($id);
            $subProduct->delete();
            $response['status'] = 'success';
            return response()->json($response);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }

    }


    public function uploadGalleryimage(Request $request)
    {

        $original_filename = $request->file('file')->getClientOriginalName();

        $idpost = $request->input('idedit');
        $extension = $request->file('file')->getClientOriginalExtension();
        $allowedextensions = array('JPG', 'JPEG', 'PNG', 'GIF');

        if (!in_array(strtoupper($extension), $allowedextensions)) {
            return 0;
        }
        $disk = 'publicmedia';
        $image = \Image::make($request->file('file'));
        $name = str_slug(str_replace('.' . $extension, '', $original_filename), '-');


        $image->fit(config('asgard.iblog.config.imagesize.width'), config('asgard.iblog.config.imagesize.height'), function ($constraint) {
            $constraint->upsize();
        });

        if (config('asgard.iblog.config.watermark.activated')) {
            $image->insert(config('asgard.iblog.config.watermark.url'), config('asgard.iblog.config.watermark.position'), config('asgard.iblog.config.watermark.x'), config('asgard.iblog.config.watermark.y'));
        }
        $nameimag = $name . '.' . $extension;
        $destination_path = 'assets/icommerce/product/gallery/' . $idpost . '/' . $nameimag;

        \Storage::disk($disk)->put($destination_path, $image->stream($extension, '100'));

        return array('direccion' => $destination_path);
    }

    public function deleteGalleryimage(Request $request)
    {
        $disk = "publicmedia";
        $dirdata = $request->input('dirdata');
        \Storage::disk($disk)->delete($dirdata);
        return array('success' => true);
    }

    /**
     * Search Products Via Ajax DataTable.
     *
     * @param  none
     * @return DataTable Format
     */

    public function searchProducts(Request $request)
    {

        $query = Product::select('icommerce__products.id', 'icommerce__products.title', 'icommerce__products.sku', 'icommerce__products.price','icommerce__products.status', 'icommerce__products.created_at', 'icommerce__products.stock_status', 'icommerce__manufacturers.name')
            ->leftJoin('icommerce__manufacturers', 'icommerce__products.manufacturer_id', '=', 'icommerce__manufacturers.id')
            ->where("parent_id", 0);

        return datatables($query)->make(true);

    }

    /**
     * Search Products Via Ajax Select 2.
     *
     * @param  q
     * @return Products
     */
    public function searchProductsRelated()
    {

        $data = array();
        $q = Input::get('q');

        $products = Product::select('id', 'title')
            ->where([
                ["parent_id", "=", 0],
                ["title", "like", "%{$q}%"],
            ])->get();

        $data["data"] = $products;

        return response()->json($data);

    }


    /**
     * Save Metas.
     *
     * @param  Request $request
     * @param  Object $product
     * @return nothing
     */

    public function saveMetas(Request $request, $product)
    {

        if (empty($request->meta_title)) {
            $request->meta_title = $product->title;
        }
        $this->saveFake($product, "meta_title", $request->meta_title);

        if (empty($request->meta_description)) {
            $request->meta_description = substr(strip_tags($product->description), 0, 150);;
        }
        $this->saveFake($product, "meta_description", $request->meta_description);

        $this->saveFake($product, "meta_keyword", $request->meta_keyword);
    }

    /**
     * Save Fakes.
     *
     * @param  Object $product
     * @param  String $metaname
     * @param  String $metavalue
     * @return
     */

    public function saveFake($product, $metaname, $metavalue)
    {
        $options = (array)$product->options;
        $options["{$metaname}"] = $metavalue;
        $product->options = json_encode($options);
        $product->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return Response
     */

    public function destroy(Product $product)
    {
        try {
            $result = $this->product->destroy($product);
            return redirect()->route('admin.icommerce.product.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::products.title.products')]));
        } catch (\Illuminate\Database\QueryException $e) {

            //$error = $e->errorInfo[2];
            return redirect()->route('admin.icommerce.product.index')
                ->withError(trans('icommerce::products.validation.error delete'));
        }
    }

    /**
     * view import and export from products.
     * @return View
     */

    public function indeximport()
    {

        return view('icommerce::admin.products.bulkload.index');
    }

    public function importProducts(Request $request)
    {
        $msg="";
        $data = ['folderpaht' => $request->folderpaht, 'user_id' => $this->auth->user()->id, 'Locale'=>$request->Locale];

        $data_excel = Excel::Load($request->importfile, function ($reader) {
            $excel = $reader->all();
            return $excel;
        });


        foreach ($data_excel->parsed as $i => $page) {


            switch ($page->getTitle()) {

                case 'Categories':
                    try {
                        BulkloadCategory::dispatch(json_decode(json_encode($page)), $data);
                    } catch (Exception $e) {
                        $msg =  trans('icommerce::products.bulkload.error in migrate from category');
                        return redirect()->route('admin.icommerce.product.index')
                            ->withError($msg);
                    }
                    break;
                case 'manufactures':

                    try {
                        BulkloadManufacturer::dispatch(json_decode(json_encode($page)), $data);
                    } catch (Exception $e) {
                        $msg  =  trans('icommerce::products.bulkload.error in migrate from manufacturer');
                        return redirect()->route('admin.icommerce.product.index')
                            ->withError($msg);
                    }
                    break;
                case 'Products':
                    try {
                        $this->product->jobs_bulkload(json_decode(json_encode($page)),50,$data);

                    } catch (Exception $e) {
                        $msg = trans('icommerce::products.bulkload.error in migrate from page');
                        return redirect()->route('admin.icommerce.product.index')
                            ->withError($msg);

                    }
                    break;
                default:


            };
            $msg=trans('icommerce::products.bulkload.success migrate from product');

        }

        return redirect()->route('admin.icommerce.product.index')
            ->withSuccess($msg);

    }

}