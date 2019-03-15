<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Entities\Product;
// class ProductsImport implements ToCollection,WithChunkReading,ShouldQueue
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
          // Search by id
          $product=$this->product->find($product_id);
          if(!$product){
            //Products do not exist, mandatory fields to create it
            if(!isset($row->title))
            throw new \Exception('Product with id: '.$row->id.', it is necessary that you have a title');
            if(!isset($row->description))
            throw new \Exception('Product with id: '.$row->id.', it is necessary that you have a description');
            // if(!isset($row->summary))
            // throw new \Exception('Product with id: '.$row->id.', it is necessary that you have a summary');
          }//Products not exist
          $param=[];
          $param['id']=$product_id;
          $param['user_id']=$this->info['user_id'];
          $image=null;
          $options=null;
          if(isset($row->sku)){
            $sku=$row->sku;
            $param['sku']=$sku;
          }
          if(isset($row->title)){
            $title=(string)$row->title;
            $param['title']=$title;
            $param['slug']=str_slug($title);
          }
          if(isset($row->description) && strlen($row->description)<=150){
            //Max 150 characters
            $description=(string)$row->description;
            $param['description']=$description;
            $param['summary']=$description;
          }
          // if(isset($row->summary)){
          //   $summary=(string)$row->summary;
          //   $param['summary']=$summary;
          // }
          if(isset($row->category_id)){
            $category_id=(int)$row->category_id;
            $param['category_id']=$category_id;
          }
          if(isset($row->quantiy)){
            $quantity=(int)$row->quantity;
            $param['quantiy']=$quantity;
          }
          if(isset($row->stock_status)){
            $stock_status=(int)$row->stock_status;
            $param['stock_status']=$stock_status;
          }
          if(isset($row->manufacter_id) && !empty($row->manufacter_id)){
            $manufacturer_id=(int)$row->manufacter_id;
            $param['manufacturer_id']=$manufacturer_id;
          }
          if(isset($row->price)){
            $price=(int)$row->price;
            $param['price']=$price;
          }
          if(isset($row->weight)){
            $weight=(int)$row->weight;
            $param['weight']=$weight;
          }
          if(isset($row->length)){
            $length=(int)$row->lenght;
            $param['length']=$length;
          }
          if(isset($row->width)){
            $width=(int)$row->width;
            $param['width']=$width;
          }
          if(isset($row->height)){
            $height=(int)$row->height;
            $param['height']=$height;
          }
          if(isset($row->minimum)){
            $minimum=(int)$row->minimum;
            $param['minimum']=$minimum;
          }
          if(isset($row->minimum)){
            $minimum=(int)$row->minimum;
            $param['minimum']=$minimum;
          }
          if(isset($row->image)){
            $image=(string)$row->image;
            //$param['image']=$image;
          }
          if(isset($row->tax_class_id)){
            $tax_class_id=(int)$row->tax_class_id;
            $param['tax_class_id']=$tax_class_id;
          }
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
          if($options!=null){
            $options=json_encode($options);
            $param['options']=$options;
          }
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
        \Log::error('Products Import error: '.$e->getMessage());
        //dd($e->getMessage());
      }//catch
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
