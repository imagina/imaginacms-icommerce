<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Entities\Cart;
use Modules\Icommerce\Entities\ProductOptionValue;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
// Entities
use Modules\Icommerce\Entities\CartProduct;
use Illuminate\Support\Arr;

class EloquentCartProductRepository extends EloquentBaseRepository implements CartProductRepository
{ 

  private $log = "Icommerce: Repositories|CartProduct|";
  

  public function getItemsBy($params = false)
  {
      /*== initialize query ==*/
      $query = $this->model->query();

      /*== RELATIONSHIPS ==*/
      if(in_array('*',$params->include ?? [])){//If Request all relationships
        $query->with([]);
      }else{//Especific relationships
        $includeDefault = [];//Default relationships
        if (isset($params->include))//merge relations with default relationships
          $includeDefault = array_merge($includeDefault, $params->include);
        $query->with($includeDefault);//Add Relationships to query
      }

      /*== FILTERS ==*/
      if (isset($params->filter)) {
        $filter = $params->filter;//Short filter

        //Filter by date
        if (isset($filter->date)) {
          $date = $filter->date;//Short filter date
          $date->field = $date->field ?? 'created_at';
          if (isset($date->from))//From a date
            $query->whereDate($date->field, '>=', $date->from);
          if (isset($date->to))//to a date
            $query->whereDate($date->field, '<=', $date->to);
        }

        //Order by
        if (isset($filter->order)) {
          $orderByField = $filter->order->field ?? 'created_at';//Default field
          $orderWay = $filter->order->way ?? 'desc';//Default way
          $query->orderBy($orderByField, $orderWay);//Add order to query
        }

        //add filter by search
        if (isset($filter->search)) {
          //find search in columns
          $query->where(function ($query) use ($filter) {
          $query->where('id', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
            });
        }

        if (isset($filter->cartId)){
          $query->where('cart_id', $filter->cartId);
        }

        if (isset($filter->productId)){
          $query->where('product_id', $filter->productId);
        }

        if (isset($filter->isCall)){
          $query->where('is_call', $filter->isCall);
        }

        if (isset($filter->optionsDynamicsIds)){
          $optionsDynamicIds = $filter->optionsDynamicsIds;
          $query->whereHas('optionsDynamics', function ($query) use ($optionsDynamicIds) {
            $query->whereIn("option_id",$optionsDynamicIds);
          });
        }

      }

      /*== FIELDS ==*/
      if (isset($params->fields) && count($params->fields))
        $query->select($params->fields);

      /*== REQUEST ==*/
      if (isset($params->page) && $params->page) {
        return $query->paginate($params->take);
      } else {
        isset($params->take) && $params->take ? $query->take($params->take) : false;//Take
        return $query->get();
      }

  }

  public function getItem($criteria, $params = false)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();

    $query->where('id', $criteria);

    // RELATIONSHIPS
    $includeDefault = ['productOptionValues'];
    if (isset($params->include))//merge relations with default relationships
      $includeDefault = array_merge($includeDefault, $params->include);

    $query->with($includeDefault);//Add Relationships to query


    // FIELDS
    if (isset($params->fields) && count($params->fields)) {
      $query->select($params->fields);
    }
    return $query->first();

  }

  public function create($data){
    
    //\Log::info($this->log."Create");

    $data["quantity"] = abs($data["quantity"]);
    $productRepository = app('Modules\Icommerce\Repositories\ProductRepository');

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
      if (!$this->productHasValidQuantity($product,$product->optionValues, $data, $cartProduct, $productOptionValues)) {
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
        //$cartProduct->optionsDynamics()->sync($optionsDynamic);
        
        //Con esto se soluciono
        $cartProduct->optionsDynamics()->attach($optionsDynamic);
       
      }

    }else {

      //Case - Cart Product Exist

      //NO dynamics options - Check
      if(count($data["product_option_values"])>0){

        // get product options
        $productOptionValues = $cartProduct->productOptionValues;
        // get options from front
        $productOptionValuesFront = Arr::get($data, 'product_option_values', []);

        // if product doesn't have the same options wil be created and sync options
        $productOptionValuesIds = $productOptionValues->pluck('id')->toArray();

        if( array_diff($productOptionValuesIds, $productOptionValuesFront) !== array_diff($productOptionValuesFront, $productOptionValuesIds)){
            $cartProduct = $this->model->create($data);
            $cartProduct->productOptionValues()->sync($productOptionValuesFront);
        }else{
          // if product have the same options update quantity and update
          $data['quantity'] += $cartProduct->quantity;
          $cartProduct->update($data);
        }

      }

      //Dynamics options - Check
      if(count($optionsDynamic)>0){

        //Cart Products con la informacion de opciones dinamicas
        $cartProducts = $this->findCartProductsWithDynamics($optionsDynamic,$data);
        
        //Opciones dinamicas agrupadas
        $allOptionsDynamicsInCart = $this->groupAllOptionsDynamics($cartProducts);

        //Recorrer las opciones nuevas
        foreach ($optionsDynamic as $key => $optionsFront) {
          $cartProductId = null;
          //Se evaluan todas las opciones del carrito, para ver si ya existe una con la misma informacion
          foreach ($allOptionsDynamicsInCart as $key => $optionCart) {
            if($optionsFront['option_id']==$optionCart['option_id'] && $optionsFront['value']==$optionCart['value']){
              $cartProductId = $optionCart['cartProductId'];
              break;
            }
          }

          //Check Result
          if(is_null($cartProductId)){
              //Create cart product
              $cartProduct = $this->model->create($data);
              $newDataOption[] = $optionsFront;
              $cartProduct->optionsDynamics()->attach($newDataOption);
          }else{
              //Update a specific cart product
              $cartProductUpdate =  $this->getItem($cartProductId);
              $data['quantity'] += $cartProductUpdate->quantity;
              $cartProductUpdate->update($data);
          }

        }
        
      }else{
        //\Log::info($this->log."create|Not Options Dynamics");
        $cartProduct = $this->model->create($data);
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
      $productOptionValuesIdsFront = array_column($productOptionValuesFront,'id');
      // if is the same option values ids
   
      if( array_diff($productOptionValuesIds, $productOptionValuesIdsFront) === array_diff($productOptionValuesIdsFront, $productOptionValuesIds)){
        $cartProduct->update($data);
  
      }else{ // if not the same options create cart product
        $cartProduct = $this->model->create($data);
      } 
    }
    return $cartProduct;
  }

  public function deleteBy($criteria, $params = false)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();

    // FILTER
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field)) //Where field
        $query->where($filter->field, $criteria);
      else //where id
        $query->where('id', $criteria);
    }else{
      $query->where('id', $criteria);
    }


    // REQUEST
    $model = $query->first();

    if($model) {
      $model->delete();
      
      return true;
    }else{
      return false;
    }
  }
  
  public function findByAttributesOrOptions($data){

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
  
  private function productHasValidQuantity($product, $productOptionsValues, $data, $cartProduct, $productOptionValuesFrontend)
  {
    $validQuantity = true;
  
    $cartProductQuantity = 0;
   
    //buscamos los productos que ya estén añadidos al carrito actual
    if(isset($cartProduct->id)){
      $cartProducts = $cartProduct->cart->products;
    }else{
      $cart = Cart::find($data["cart_id"]);
      $cartProducts = $cart->products;
    }
  
    //buscamos en el carrito los productos con el mismo ID para poder validad el quantity principal del producto
      foreach ($cartProducts as $cartSingleProduct){
        if($cartSingleProduct->product_id == $data["product_id"]) {
          $cartProductQuantity+= $cartSingleProduct->quantity;
        }
      }
      
    $quantity = $data["quantity"] + $cartProductQuantity;

    if($product->subtract){ // si el producto se substrae de inventario
  
      // si la cantidad del producto no alcanza para lo solicitado
      if($product->quantity < $quantity){
        $validQuantity = false;
      }else{
        if(!empty($data["product_option_values"])){ // si están añadiendo el producto con opciones
          foreach ($productOptionValuesFrontend as $productOptionValue) { // recorriendo las opciones añadidas
        
            foreach ($productOptionsValues as $productOptionsValue) { // recorriendo las options values del producto
              
              //si el value del producto se debe substraer de inventario y coincide con el que se está añadiendo al carrito
             if($productOptionsValue->subtract && $productOptionsValue->option_value_id == $productOptionValue->option_value_id){
  
               //dd($quantity,$productOptionsValue->subtract,$productOptionValue["optionValueId"],$productOptionsValue, $productOptionsValue->option_value_id == $productOptionValue["optionValueId"]);
               //si la cantidad de unidades para el valor de opcion no alcanza para lo solicitado
              if($productOptionsValue->quantity < $quantity){
                //dd($productOptionsValue->quantity,$quantity);
                $validQuantity = false;
              }
             }
            }
          }
        }
      }
    }
    //dd($quantity,$productOptionsValues,$data,$cartProduct);
    return $validQuantity;
  }

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
   * @param $optionsDynamics (From Frontend)
   */
  public function findCartProductsWithDynamics($optionsDynamic,$data)
  {

    //\Log::info($this->log."findCartProductsWithDynamics");

    $optionsDynamicIds = array_column($optionsDynamic, 'option_id');

    $params = [
      "filter" => [
        "cartId" => $data['cart_id'],
        "productId" => $data['product_id'],
        "isCall" => $data['is_call'] ?? false,
        'optionsDynamicsIds' => $optionsDynamicIds
      ]
    ];

    $cartProducts = $this->getItemsBy(json_decode(json_encode($params)));

    return $cartProducts;

  }

  public function groupAllOptionsDynamics($cartProducts)
  {

    //\Log::info($this->log."groupAllOptionsDynamics");

    $allOptionsDynamicsInCart = [];
    //Se obtienen las opciones para cada producto.
    foreach ($cartProducts as $key => $cartProduct) {
      $cartProductId = $cartProduct->id;
      /**
       * Hay que agruparlas por el caso de que existan 2 productos con opciones, 
       * Si se intenta actualizar el 2do, puede que el primero no tenga esa opcion y la agregaria (cuando no deberia)
       */
      foreach ($cartProduct->optionsDynamics as $key => $option) {
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
