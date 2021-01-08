<?php

namespace Modules\Icommerce\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Entities\ProductList;
class SaveProductsPriceLists implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $productIds;
    protected $priceList;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productIds,$priceList)
    {
        $this->productIds = $productIds;
        $this->priceList = $priceList;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      if($this->priceList->criteria=="percentage"){
        //Discount or increment price
        if(is_array($this->productIds)){
          foreach(Product::find($this->productIds) as $product){
            $value=($product->price*$this->priceList->value)/100;//Example value pricelist = 5 (Calculate 5%)
            $price=$product->price;
            if($this->priceList->operation_prefix=="-"){
              $price-=$value;
            }else{
              $price+=$value;
            }
            ProductList::firstOrCreate([
              "product_id"=>$product->id,
              "price_list_id"=>$this->priceList->id,
            ],[
              "price"=>$price,
            ]);
          }//foreach
        }else{
          \Log::error("Job: SaveProductsPriceLists -> Error: Variable productIds is not array");
        }
      }
    }
}
