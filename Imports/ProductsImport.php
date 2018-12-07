<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\ProductRepository;

class ProductsImport implements ToCollection,WithChunkReading,ShouldQueue
{

    private $product;
    private $info;

    public function __construct(
        ProductRepository $product,
        $info
    ){
      $this->info=$info;
        $this->product = $product;
    }

     /**
     * Data from Excel
     */
    public function collection(Collection $rows)
    {
      \App::setLocale($this->info['Locale']);
        foreach ($rows as $row)
        {
            try {
              if(isset($row[0]) && $row[0]!='id'){
                if((int)$row[0]==0)
                throw new Exception('Product with id: '.(int)$row[0].' not exist');
                $product_id=(int)$row[0];
                $sku=(int)$row[2];
                $title=(string)$row[3];
                $description=(string)$row[4];
                $summary=(string)$row[5];
                $category_id=(int)$row[6];
                $quantity=(int)$row[8];
                $stock_status=(int)$row[9];
                $manufacturer_id=null;
                if(!empty($row[10]))
                  $manufacturer_id=(int)$row[10];
                $price=(int)$row[11];
                $weight=(int)$row[12];
                $length=(int)$row[13];
                $width=(int)$row[14];
                $height=(int)$row[15];
                $minimum=(int)$row[16];
                $reference=(int)$row[17];
                $image=(int)$row[18];
                $tax_class_id=(int)$row[19];
                $options=null;
                // Search by id
                $product=$this->product->find($product_id);
                if (isset($this->info['folderpaht'])) {
                    if (isset($image) && !empty($image)) {
                        $picture = $this->info['folderpaht'] . 'products/' . str_replace(' ', '', $image);
                        if (\Storage::disk('publicmedia')->exists($picture)){
                            $destination_path = 'assets/icommerce/product/' . $product_id . '.jpg';
                            $img = $this->saveimage($destination_path, $picture);
                        }else{
                            $img='modules/icommerce/img/product/default.jpg';
                        }
                        $options["mainimage"] = $img;
                    }//isset image
                }//folderpath
                else {
                   if($product)
                   $options = $product->options;
                }
                $options=json_encode($options);
                $param = [
                  'id'=>$product_id,
                  'title'=>$title,
                   'slug'=>str_slug($title),
                   'description'=>$description,
                   'summary'=>$summary,
                   'options'=>$options,
                   'user_id'=>$this->info['user_id'],
                   'category_id'=>$category_id,
                   'parent_id'=>0,
                   'sku'=>$sku,
                   'quantity'=>$quantity,
                   'stock_status'=>$stock_status,
                   'manufacturer_id'=>$manufacturer_id,
                   'price'=>$price,
                   'weight'=>$weight,
                   'length'=>$length,
                   'width'=>$width,
                   'height'=>$height,
                   'minimum'=>$minimum,
                   'reference'=>$reference,
                   'order_weight'=>null
                ];
                if($product){
                  //Update
                  $this->product->update($product,  $param);
                  \Log::info('Update Product: '.$product->id.', Title: '.$product->title);
                }else{
                  //Create
                  $newProduct = $this->product->create($param);
                  // Take id from excel
                  $newProduct->id = $param["id"];
                  $newProduct->save();
                  \Log::info('Create a Product: '.$param['title']);
                }
              }//if row!=name
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                // dd($e->getMessage());
            }

        }// foreach

    }//collection rows

    public function saveimage($destination_path, $picture)
    {

        $disk = 'publicmedia';
        try {
            if (\Storage::disk('publicmedia')->exists($picture)) {
                $image = \Image::make(\Storage::disk('publicmedia')->url($picture));


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
            }

            // 3. Return the path
            return $destination_path;
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    /*
    The most ideal situation (regarding time and memory consumption)
    you will find when combining batch inserts and chunk reading.
    */
    public function batchSize(): int
    {
        return 1000;
    }

    /*
     This will read the spreadsheet in chunks and keep the memory usage under control.
    */
    public function chunkSize(): int
    {
        return 1000;
    }

}
