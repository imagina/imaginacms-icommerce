<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\Product_Option_ValueRepository;
use Modules\Icommerce\Entities\Product_Option;
use Modules\Icommerce\Entities\Product_Option_Value;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Entities\Option;
use Modules\Icommerce\Entities\Option_Value;

class ProductOptionValuesImport implements ToCollection,WithChunkReading,WithHeadingRow,ShouldQueue
{

    private $product_option_values;
    private $info;
    public function __construct(
        Product_Option_ValueRepository $product_option_values,
        $info

    ){
        $this->product_option_values = $product_option_values;
        $this->info = $info;
    }

     /**
     * Data from Excel
     */
    public function collection(Collection $rows)
    {
        \App::setLocale($this->info['Locale']);
        $rows=json_decode(json_encode($rows));
        foreach ($rows as $row)
        {
            try {
                if(isset($row->id)){
                  $param=[];
                  $product_option_value_id=(int)$row->id;
                  $option_id=(int)$row->option_id;
                  $option_value_id=(int)$row->option_value_id;
                  $children_option_value_id=0;
                  $product_option_id=(int)$row->product_option_id;
                  $product_id=(int)$row->product_id;
                  $price_prefix=(string)$row->price_prefix;
                  $points_prefix=(string)$row->points_prefix;
                  $weight_prefix=(string)$row->weight_prefix;
                  $quantity=(float)$row->quantity;
                  $subtract=(int)$row->subtract;
                  $price=(float)$row->price;
                  $points=(int)$row->points;
                  $weight=(int)$row->weight;
                  if(!Product::find($product_id))
                    throw new \Exception('Product with id: '.$row->product_id.', not exist');
                  if(!Option::find($option_id))
                    throw new \Exception('Option with id: '.$row->option_id.', not exist');
                  if(!Option_Value::where('id',$option_value_id)->where('option_id',$option_id)->first())
                    throw new \Exception('Option Value with id: '.$row->option_value_id.', not exist');
                  if(!Product_Option::where('id',$product_option_id)->where('option_id',$option_id)->where('product_id',$product_id)->first())
                    throw new \Exception('Product Option with id: '.$row->product_option_id.', not exist');
                  if(isset($row->children_option_value_id) && (int)$row->children_option_value_id!=0){
                    if(!Option_Value::find($row->children_option_value_id))
                      throw new \Exception('Children Option Value with id: '.$row->children_option_value_id.', not exist');
                    $children_option_value_id=$row->children_option_value_id;
                  }
                  //data
                  $param = [
                    'id' => (int)$product_option_value_id,
                    'option_id'=>(int)$option_id,
                    'product_option_id'=>(int)$product_option_id,
                    'option_value_id'=>(int)$option_value_id,
                    'children_option_value_id'=>(int)$children_option_value_id,
                    'product_id'=>(int)$product_id,
                    'price_prefix'=>(string)$price_prefix,
                    'points_prefix'=>(string)$points_prefix,
                    'weight_prefix'=>(string)$weight_prefix,
                    'quantity'=>(int)$quantity,
                    'subtract'=>(int)$subtract,
                    'price'=>(float)$price,
                    'points'=>(float)$points,
                    'weight'=>(float)$weight
                  ];
                  // Search by id
                  $product_option_value = $this->product_option_values->find($product_option_value_id);
                  if($product_option_value){
                    // Update
                    $this->product_option_values->update($product_option_value,  $param);
                    \Log::info('Update Product Option Values id: '.$product_option_value->id);
                  }else{
                    // Create
                    $newProductOptionVal = $this->product_option_values->create($param);
                    // Take id from excel
                    $newProductOptionVal->id = $param["id"];
                    $newProductOptionVal->save();
                    \Log::info('Create a Product Option Values id: '.$param['id']);
                  }//else
                }//if isset product option value
            } catch (\Exception $e) {
                \Log::error('Product Option Values Import error: '.$e->getMessage());
                // dd($e->getMessage());
            }

        }// foreach

    }

    /*
    The most ideal situation (regarding time and memory consumption)
    you will find when combining batch inserts and chunk reading.
    */
    public function batchSize(): int
    {
        return 500;
    }

    /*
     This will read the spreadsheet in chunks and keep the memory usage under control.
    */
    public function chunkSize(): int
    {
        return 500;
    }

}
