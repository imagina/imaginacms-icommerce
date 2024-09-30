<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Illuminate\Support\Arr;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Icommerce\Entities\ProductOptionValue;
use Modules\Icommerce\Entities\CartProduct;
use Modules\Icommerce\Entities\Cart;

class EloquentCartProductRepository extends EloquentCrudRepository implements CartProductRepository
{ 
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = [];

  /**
   * Relation names to replace
   * @var array
   */
  protected $replaceSyncModelRelations = [];

  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @param $params
   * @return mixed
   */

  private $log = "Icommerce: Repositories|CartProduct|";
  
  public function filterQuery($query, $filter, $params)
  {

    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */
        //add filter by search
        if (isset($filter->search)) {
          //find search in columns
          $query->where(function ($query) use ($filter) {
          $query->where('id', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
            });
        }

        if (isset($filter->dynamicOptionsIds)){
          $dynamicOptionsIds = $filter->dynamicOptionsIds;
          $query->whereHas('dynamicOptions', function ($query) use ($dynamicOptionsIds) {
            $query->whereIn("option_id",$dynamicOptionsIds);
          });
        }
    //Response
    return $query;
      }

  /**
   * Method to sync Model Relations
   *
   * @param $model ,$data
   * @return $model
   */
  public function syncModelRelations($model, $data)
  {
    //Get model relations data from attribute of model
    $modelRelationsData = ($model->modelRelations ?? []);

    /**
     * Note: Add relation name to replaceSyncModelRelations attribute before replace it
     *
     * Example to sync relations
     * if (array_key_exists(<relationName>, $data)){
     *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
     * }
     *
     */

    //Response
    return $model;
  }

  public function create($data){
    

    $data["quantity"] = abs($data["quantity"]);
    $productRepository = app('Modules\Icommerce\Repositories\ProductRepository');
  
    $warehouse = request()->session()->get('warehouse');
    $warehouse = json_decode($warehouse);
    if (isset($warehouse->id)) {
      $warehouse = app('Modules\Icommerce\Repositories\WarehouseRepository')->getItem($warehouse->id);
    }

    $warehouseEnabled = setting('icommerce::warehouseFunctionality',null,false);
  
    if($warehouseEnabled && isset($warehouse->id)){
      $data["warehouse_id"] = $warehouse->id;
    }
    //To include all products even if they are internal (as in the case of services in reservations)
    $params = [
      "filter" => [
        "ValidationInternal" => true,
      ],
      "include" => [],
      "fields" => [],
    ];

    $product = $productRepository->getItem($data["product_id"],json_decode(json_encode($params)));
  
    if (!isset($product->id)) {
      throw new \Exception("Invalid product", 400);
    }
    
    //Separate Options to new process
    $result = $this->separateOptions($data["product_option_values"]);
    $optionsDynamic = $result['optionsDynamic'];
    $data["product_option_values"] = $result['pov'];
   
    //Search Product Option Values
    $productOptionValues = ProductOptionValue::whereIn("id",$data["product_option_values"] ?? [])->get();

    // validate required options
    if ($product->present()->hasRequiredOptions && !$this->productHasAllOptionsRequiredOk($product->productOptions, $productOptionValues, $optionsDynamic)) {
      throw new \Exception("Missing required product options", 400);
    }

    // if the request has product without options
    $cartProduct = $this->findByAttributesOrOptions($data);
 
    //validate setting canAddIsCallProductsIntoCart
    if(!isset($data["is_call"]) || (isset($data["is_call"]) && !$data["is_call"])){
      // validate valid quantity
      if (!$this->productHasValidQuantity($cartProduct, $product, $product->optionValues, $data, $productOptionValues)) {
        throw new \Exception("Product Quantity Unavailable", 400);
      }
    }

    //if not found product into cart with the same options
    if(!$cartProduct) {
      $data["organization_id"] = $product->organization_id ?? null;
      $cartProduct = $this->model->create($data);

      //Sync NO dynamics options
      if(count($data["product_option_values"])>0){
        //\Log::info($this->log.'Create|Sync Product Options Values');
        $cartProduct->productOptionValues()->sync(Arr::get($data, 'product_option_values', []));
      }
     
      //Sync Dynamics options
      if(count($optionsDynamic)>0){
        //\Log::info($this->log.'Create|Sync Dinamics Options');
       
        //#CasoX = Si existe una opcion "NoDinamica" y una "Dinamica". Agregaba la "NoDinamica" pero la "Dinamica" negative.
        //$cartProduct->dynamicOptions()->sync($optionsDynamic);
        
        //Con esto se soluciono
        $cartProduct->dynamicOptions()->attach($optionsDynamic);
       
      }

    }else {

      //Case - Cart Product Exist

      //Dynamics options - Check
      if(count($optionsDynamic)>0){

        \Log::info($this->log."create|Options Dynamics");

        //Cart Products con la informacion de opciones dinamicas
        $cartProducts = $this->findCartProductsWithDynamics($optionsDynamic,$data);
        
        //Opciones dinamicas agrupadas
        $allOptionsDynamicsInCart = $this->groupAllOptionsDynamics($cartProducts);

        //Recorrer las opciones nuevas (Las que vienen del Frontend)
        foreach ($optionsDynamic as $key => $optionsFront) {
          $cartProductId = null;
          //Se evaluan todas las opciones del carrito, para ver si ya existe una con la misma informacion
          foreach ($allOptionsDynamicsInCart as $key => $optionCart) {
            if($optionsFront['option_id']==$optionCart['option_id'] && $optionsFront['value']==$optionCart['value']){
              $cartProductId = $optionCart['cartProductId']; //Ya existe esa opcion, con esto ya sabemos que producto actualizar del carrito
              break;
            }
          }

          //Check Result
          if(is_null($cartProductId)){
              //Create cart product
            $cartProduct = $this->model->create($data);
              $newDataOption[] = $optionsFront;
              $cartProduct->dynamicOptions()->attach($newDataOption);
          }else{
              //Update a specific cart product
              $cartProductUpdate =  $this->getItem($cartProductId);
              $data['quantity'] += $cartProductUpdate->quantity;
              $cartProductUpdate->update($data);
          }

        }
        
      }else{

        \Log::info($this->log."create|NOT Options Dynamics");
    
        // get product options
        $productOptionValues = $cartProduct->productOptionValues;
        // get options from front
        $productOptionValuesFront = Arr::get($data, 'product_option_values', []);

        $productOptionDynamics = $cartProduct->dynamicOptions;
        
        // if product doesn't have the same options wil be created and sync options
        $productOptionValuesIds = $productOptionValues->pluck('id')->toArray();

        /**
         * Agregada validacion $productOptionDynamics->isNotEmpty() 
         * Caso de Uso: Cuando ya existe producto con opciones dinamicas y se envia a guardar sin opciones dinamicas (q deberia ser otro)
         * se rectifica con esa relacion para evitar que le sume "quantity" al producto anterior
         */
        if($productOptionDynamics->isNotEmpty() || array_diff($productOptionValuesIds, $productOptionValuesFront) !== array_diff($productOptionValuesFront, $productOptionValuesIds)){
            $cartProduct = $this->model->create($data);
            $cartProduct->productOptionValues()->sync($productOptionValuesFront);
        }else{

          // if product have the same options update quantity and update
          $data['quantity'] += $cartProduct->quantity;
          $cartProduct->update($data);
        }

      }

    }
    return $cartProduct;
  }

  public function updateBy($criteria, $data, $params = false){

    // INITIALIZE QUERY
    $cartProduct = $this->findByAttributesOrOptions($data);
    
    if($cartProduct) {
 
      // get product options
      $productOptionValues = $cartProduct->productOptionValues;
      
      // get options from front
      $productOptionValuesFront = Arr::get($data, 'product_option_values', []);
  
      $productOptionValuesIds = $productOptionValues->pluck('id')->toArray();

      // if is the same option values ids
      if( array_diff($productOptionValuesIds, $productOptionValuesFront) === array_diff($productOptionValuesFront, $productOptionValuesIds)){
        $cartProduct->update($data);
  
      }else{ // if not the same options create cart product
        $cartProduct = $this->model->create($data);
      } 
    }
    return $cartProduct;
  }

  public function findByAttributesOrOptions($data)
  {

    // if the request has product without options
    if(!count(Arr::get($data, 'product_option_values', []))) {
      // find product into cart by attributes
      $cartProduct = CartProduct::where('cart_id',$data['cart_id'])
        ->where('product_id', $data['product_id'])
        ->where('is_call', $data['is_call'] ?? false)
        ->has('productOptionValues', 0)->first();
    }else{
      // get options from front
      $productOptionValuesIdsFront = Arr::get($data, 'product_option_values', []);

      // find product into cart where has the same options
      $cartProducts = CartProduct::where('cart_id',$data['cart_id'])
        ->where('product_id', $data['product_id'])
        ->where('is_call', $data['is_call'] ?? false)
        ->whereHas('productOptionValues', function ($query) use ($productOptionValuesIdsFront) {
          $query->whereIn("product_option_value_id",$productOptionValuesIdsFront);
        })->get();

      foreach ($cartProducts as $cartProductQuery){
        // get product options
        $productOptionValuesIds = $cartProductQuery->productOptionValues->pluck('id')->toArray();

          if( array_diff($productOptionValuesIds, $productOptionValuesIdsFront) === array_diff($productOptionValuesIdsFront, $productOptionValuesIds)){

            $cartProduct = $cartProductQuery;
        
          }
      }
    }

    return $cartProduct ?? false;
  }
  
  
  private function productHasAllOptionsRequiredOk($productOptions, $productOptionValues,$optionsDynamic)
  {

    $allRequiredOptionsOk = true;
    foreach ($productOptions as $productOption) {
      $optionOk = true;
      if ($productOption->pivot->required) {
        $optionOk = false;

        //No Dynamic
        if($productOption->dynamic==0){
          foreach ($productOptionValues as $productOptionValue) {
            $productOption->id == $productOptionValue->option_id ? $optionOk = true : false;
          }
        }else{
          //Dynamic
          foreach ($optionsDynamic as $od) {
            $productOption->id == $od['option_id'] ? $optionOk = true : false;
          }
        }

      }
      !$optionOk ? $allRequiredOptionsOk = false : false;
    }
    
    return $allRequiredOptionsOk;
  }
  
  public function productHasValidQuantity($cartProduct, $product = null, $productOptionsValues = null, $data = null, $productOptionValuesFrontend = null)
  {
    $validQuantity = true;
  
    $cartProductQuantity = 0;
  
    if(empty($product)){
      $product = $cartProduct->product;
    }
  
    if(empty($productOptionsValues)){
      $productOptionsValues = $product->optionValues;
    }
 
    if(empty($productOptionValuesFrontend)){
      //Search Product Option Values
      $productOptionValuesFrontend = $cartProduct->productOptionValues;
      
    }
    //buscamos los productos que ya estén añadidos al carrito actual
    if(isset($cartProduct->id)){
      $cartProducts = $cartProduct->cart->products;
    }else{
      $cart = Cart::find($data["cart_id"]);
      $cartProducts = $cart->products;
    }
  
    //buscamos en el carrito los productos con el mismo ID para poder validad el quantity principal del producto
      foreach ($cartProducts as $cartSingleProduct){
        if($cartSingleProduct->product_id == $product->id) {
          $cartProductQuantity+= $cartSingleProduct->quantity;
        }
      }
      
    $quantity = ($data["quantity"] ?? 0) + $cartProductQuantity;

    if($product->subtract){ // si el producto se substrae de inventario
  
      $warehouse = request()->session()->get('warehouse');
      $warehouse = json_decode($warehouse);
      $warehouseEnabled = setting('icommerce::warehouseFunctionality',null,false);
   
      $productQuantity = $product->quantity;
      //nueva validación para warehouses, si está activa la funcionalidad, debemos buscar el quantity en el warehouse que esté en session
      //ya que front se encarga de colocar en sesión siempre un warehouse para poder funcionar
      if($warehouseEnabled && isset($warehouse->id)){
        
        if(!isset($warehouse->id)) throw new \Exception("Missing warehouse in session", 400);
        $productQuantity = \DB::table('icommerce__product_warehouse')
            ->where('warehouse_id', $warehouse->id)
            ->where('product_id', $product->id)
            ->first();

        $productQuantity = $productQuantity->quantity ?? 0;
      }
 
      // si la cantidad del producto no alcanza para lo solicitado
      if($productQuantity < $quantity){
        $validQuantity = false;
      }else{
        if(!empty($productOptionValuesFrontend) && $productOptionValuesFrontend->isNotEmpty() && !empty($productOptionsValues) && $productOptionsValues->isNotEmpty()){ // si están añadiendo el producto con opciones
          foreach ($productOptionValuesFrontend as $productOptionValueFrontend) { // recorriendo las opciones añadidas
        
            foreach ($productOptionsValues as $productOptionsValue) { // recorriendo las options values del producto
              
              //si el value del producto se debe substraer de inventario y coincide con el que se está añadiendo al carrito
             if($productOptionsValue->subtract && $productOptionsValue->option_value_id == $productOptionValueFrontend->option_value_id){

               $productOptionsValueQuantity = $productOptionsValue->quantity;
               if($warehouseEnabled){
    
                 if(!isset($warehouse->id)) throw new \Exception("Missing warehouse in session", 400);
                 $productOptionsValueQuantity = \DB::table('icommerce__product_option_value_warehouse')
                   ->where('warehouse_id', $warehouse->id)
                   ->where('product_option_value_id', $productOptionsValue->id)
                   ->where('product_id', $productOptionsValue->product_id)
                   ->first();
  
                 $productOptionsValueQuantity = $productOptionsValueQuantity->quantity ?? 0;
               }
               //dd($quantity,$productOptionsValue->subtract,$productOptionValueFrontend["optionValueId"],$productOptionsValue, $productOptionsValue->option_value_id == $productOptionValueFrontend["optionValueId"]);
               //si la cantidad de unidades para el valor de opcion no alcanza para lo solicitado
              if($productOptionsValueQuantity < $quantity){
                //dd($productOptionsValueQuantity,$quantity, $productOptionsValue);
                $validQuantity = false;
              }
             }
            }
          }
        }
      }
    }
    //dd($quantity,$validQuantity,$productOptionsValues,$data,$cartProduct);
    return $validQuantity;
  }

  /**
   * Separamos las opciones en 2 arrays (Dinamicas y No dinamicas)
   * @param $pov (Product Options values)
   */
  private function separateOptions($pov)
  {

    $optionsDynamic = [];
    \Log::info($this->log.'separateOptions|ProductOptionValuesOld: '.json_encode($pov));

    foreach ($pov as $key => $value) {
      if(is_array($value)){
        $optionsDynamic[] = $value;
        unset($pov[$key]);
      }
    }

    \Log::info($this->log.'separateOptions|ProductOptionValuesNews: '.json_encode($pov));
    \Log::info($this->log.'separateOptions|OptionsDynamics: '.json_encode($optionsDynamic));

    return ['optionsDynamic' => $optionsDynamic, 'pov' => $pov];

  }

  /**
   * Se obtienen las opciones dinamicas de cada producto (CartProducts)
   * Este metodo se realizó por separado para no combinarlo con el metodo findByAttributesOrOptions
   * que trabaja con la misma tabla pivote pero con otra relacion y validaciones
   * 
   * @param $dynamicOptions (From Frontend) [option_id,value]
   * @return $cartProducts (Solo los productos que contengan opciones dinamicas)
   */
  public function findCartProductsWithDynamics($optionsDynamic,$data)
  {

    //\Log::info($this->log."findCartProductsWithDynamics");

    $dynamicOptionsIds = array_column($optionsDynamic, 'option_id');

    $params = [
      "filter" => [
        "cartId" => $data['cart_id'],
        "productId" => $data['product_id'],
        "isCall" => $data['is_call'] ?? false,
        'dynamicOptionsIds' => $dynamicOptionsIds
      ]
    ];

    return $this->getItemsBy(json_decode(json_encode($params)));

  }

  /**
   * Se agrupan las opciones dinamicas con su cart_product_id para que sea mas facil de validar posteriormente
   * @return $allOptionsDynamicsInCart (array) - Cada opcion con su id y valor, y el cart_product_id
   */
  public function groupAllOptionsDynamics($cartProducts)
  {

    //\Log::info($this->log."groupAllOptionsDynamics");

    $allOptionsDynamicsInCart = [];
    //Se obtienen las opciones para cada producto que estan en el carrito
    foreach ($cartProducts as $key => $cartProduct) {
      $cartProductId = $cartProduct->id;
      /**
       * Caso que se presento: Un producto tiene el valor "x", el otro tiene el valor "x2"
       * Cuando se volvia a guardar "x2", estaba modificando el primero cuando en realidad debia actualizar el "x2"
       * por eso toca agruparlas para luego revisarlas todas antes de decidir
       */
      foreach ($cartProduct->dynamicOptions as $key => $option) {
        $oldOption = [
              'cartProductId' => $cartProductId,
              'option_id' => $option->pivot->option_id,
              'value' => $option->pivot->value
        ];
        array_push($allOptionsDynamicsInCart,$oldOption);
      }
    }

    return $allOptionsDynamicsInCart;
  }

}
