<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Entities\Product;
class ProductsImport implements ToCollection,WithChunkReading,WithHeadingRow,ShouldQueue
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
        $rows=json_decode(json_encode($rows));
        foreach ($rows as $row)
        {
            try {
              if(isset($row->id)){

                $product_id=(int)$row->id;
                $sku=$row->sku;
                $title=(string)$row->name;
                $description=(string)$row->description;
                $summary=(string)$row->summary;
                $category_id=(int)$row->category_id;
                $quantity=(int)$row->quantity;
                $stock_status=(int)$row->stock_status;
                $manufacturer_id=null;
                if(!empty($row->manufacter_id))
                  $manufacturer_id=(int)$row->manufacter_id;
                $price=(int)$row->price;
                $weight=(int)$row->weight;
                $length=(int)$row->lenght;
                $width=(int)$row->width;
                $height=(int)$row->height;
                $minimum=(int)$row->minimum;
                $reference=$row->reference;
                $image=$row->image;
                $tax_class_id=isset($row->tax_class_id) ?(int)$row->tax_class_id : null;
                $options=null;
                // Search by id
                $product=$this->product->find($product_id);
                if (isset($this->info['folderpaht'])  && $this->info['folderpaht']) {
                    if (isset($image) && !empty($image)) {
                        $picture = $this->info['folderpaht'] . 'products/' . str_replace(' ', '', $image);
                        if (\Storage::disk('publicmedia')->exists($picture)){
                            $destination_path = 'assets/icommerce/product/' . $product_id . '.jpg';
                            $img = $this->saveimage($destination_path, $picture);
                        }else{
                            $img='modules/icommerce/img/product/default.jpg';
                        }
                        $options["mainImage"] = $img;
                    }//isset image
                }//folderpath
                else {
                   if($product)
                   $options = $product->options;
                }
                $param = [
                  'id'=>$product_id,
                  'name'=>$title,
                   'slug'=>str_slug($title),
                   'description'=>$description,
                   'summary'=>$summary,
                   'options'=>$options,
                   'added_by_id'=>$this->info['user_id'],
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
                  \Log::info('Update Product: '.$product->id.', Title: '.$product->name);
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
                \Log::error($e->getLine());
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
