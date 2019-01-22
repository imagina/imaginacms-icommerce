<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\Product_OptionRepository;
use Modules\Icommerce\Entities\Product_Option;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Entities\Option;

class ProductOptionImport implements ToCollection,WithChunkReading,WithHeadingRow,ShouldQueue
{

    private $product_option;
    private $info;
    public function __construct(
        Product_OptionRepository $product_option,
        $info

    ){
        $this->product_option = $product_option;
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
                  $product_option_id=(int)$row->id;
                  $option_id=(int)$row->option_id;
                  $product_id=(int)$row->product_id;
                  $value=(string)$row->value;
                  $required=(int)$row->required;
                  if(!Product::find($product_id))
                    throw new \Exception('Product with id: '.$row->product_id.', not exist');
                  if(!Option::find($option_id))
                    throw new \Exception('Option with id: '.$row->option_id.', not exist');
                  //data
                  $param = [
                    'id' => $product_option_id,
                    'option_id'=>$option_id,
                    'product_id'=>$product_id,
                    'value'=>$value,
                    'required'=>$required
                  ];
                  // Search by id
                  $product_option = $this->product_option->find($product_option_id);
                  if($product_option){
                    // Update
                    $this->product_option->update($product_option,  $param);
                    \Log::info('Update Product Option id: '.$product_option->id);
                  }else{
                    // Create
                    $newProductOption = $this->product_option->create($param);
                    // Take id from excel
                    $newProductOption->id = $param["id"];
                    $newProductOption->save();
                    \Log::info('Create a Product Option id: '.$param['id']);
                  }//if exist
                }//if isset product option
            } catch (\Exception $e) {
                \Log::error('Product Option Import error: '.$e->getMessage());
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
