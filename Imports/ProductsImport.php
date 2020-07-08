<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Entities\Product;

class ProductsImport implements ToCollection, WithChunkReading, WithHeadingRow
{

    private $product;
    private $info;

    public function __construct(
        ProductRepository $product,
        $info
    )
    {
        $this->info = $info;
        $this->product = $product;
    }

    /**
     * Data from Excel
     */
    public function collection(Collection $rows)
    {
        \App::setLocale($this->info['Locale']);
        $rows = json_decode(json_encode($rows));
        foreach ($rows as $row) {
            try {
                if (isset($row->id)) {
                    $product = Product::find($row->id);
                    $product_id = (int)($row->id ?? ($product->id ?? null));
                    $sku = (string)$row->sku ?? $product->sku;
                    $name = (string)$row->name ?? $product->name;
                    $slug = str_slug($name) ?? $product->slug;
                    $description = (string)$row->description ?? $product->description;
                    $summary = (string)$row->summary ?? $product->summary;
                    $category_id = (int)$row->category_id ?? $product->category_id;
                    if ($category_id == 0) {
                        $category_id = null;
                    }
                    $quantity = $row->quantit ?? ($product->quantity ?? 1000);
                    $stock_status = (int)$row->stock_status ?? $product->stock_status;
                    $manufacturer_id = $row->manufacter_id ?? ($product->manufacter_id ?? null);
                    $price = (int)$row->price ?? ($product->price??0);
                    $weight = (int)$row->weight ?? ($product->weight??0);
                    $length = $row->length ?? ($product->lenght??0);
                    $width = (int)$row->width ?? ($product->width??0);
                    $height = (int)$row->height ?? ($product->height??0);
                    $minimum = (int)$row->minimum ?? ($product->minimum??1);
                    $reference = (string)$row->reference ?? $product->reference;
                    $image = (string)$row->image;
                    $gallery = (string)$row->gallery;
                    $tax_class_id = isset($row->tax_class_id) ? (int)$row->tax_class_id : null;
                    $options = $row->options ?? ($product->options ?? null);
                    $status=(int)$row->status ?? ($product->status??1);
                    $param = [
                        'id' => $product_id,
                        'name' => $name,
                        'slug' => str_slug($name),
                        'description' => $description,
                        'summary' => $summary,
                        'options' => $options,
                        'added_by_id' => $this->info['user_id'],
                        'category_id' => $category_id,
                        'parent_id' => 0,
                        'status' => $status,
                        'sku' => $sku,
                        'quantity' => $quantity,
                        'tax_class_id'=>$tax_class_id,
                        'stock_status' => $stock_status,
                        'manufacturer_id' => $manufacturer_id,
                        'price' => $price,
                        'weight' => $weight,
                        'length' => $length,
                        'width' => $width,
                        'height' => $height,
                        'minimum' => $minimum,
                        'reference' => $reference,
                        'order_weight' => null,

                    ];


                    if (isset($product->id)) {                        //Update
                        $this->product->update($product, $param);
                        \Log::info('Update Product: ' . $product->id . ', Title: ' . $product->name);
                    } else {
                        //Create
                        $product = $this->product->create($param);
                        \Log::info('Create a Product: '.$product->id . ', Title: '. $param['name']);
                    }



                    if (isset($image) && !empty($image)) {

                        $item = DB::table('media__files')->select('id')->where('filename', $image)->first();
                        if (isset($item->id)) {
                            $imageselec = DB::table('media__imageables')->select('id')->where('file_id', $item->id)->where('imageable_id', $product->id)->where('imageable_type', 'Modules\Icommerce\Entities\Product')->where('zone', 'mainimage')->first();
                            if (!isset($imageselec->id)) {
                                DB::insert('insert into media__imageables (file_id, imageable_id, imageable_type, zone) values (?, ?, ?, ?)', [$item->id, $product->id, 'Modules\Icommerce\Entities\Product', 'mainimage']);
                            }


                        }

                    }

                    if ($gallery) {
                        $imagesGallery = explode(',', $gallery);

                        $galleryItems = array();
                        if (count($imagesGallery)) {
                            foreach ($imagesGallery as $item) {
                                $imageGal = DB::table('media__files')->select('id')->where('filename', $item)->first();
                                if (isset($imageGal->id)) {
                                    $imageselec = DB::table('media__imageables')->select('id')->where('file_id', $imageGal->id)->where('imageable_id', $product->id)->where('imageable_type', 'Modules\Icommerce\Entities\Product')->where('zone', 'gallery')->first();
                                    if (!isset($imageselec->id)) {
                                        DB::insert('insert into media__imageables (file_id, imageable_id, imageable_type, zone) values (?, ?, ?, ?)', [$imageGal->id, $product->id, 'Modules\Icommerce\Entities\Product', 'gallery']);
                                    }


                                }
                            }
                        }
                    }
                    if (isset($row->categories)) {
                        if (strpos($row->categories, ',') === false) {
                            $categories = explode('.', $row->categories);
                        } else {
                            $categories = explode(',', $row->categories);
                        }
                        $product->categories()->sync($categories);
                    }

                }//if row!=name
            } catch (\Exception $e) {
                \Log::info(json_encode($row));
                \Log::error($e);
                \Log::error($e->getLine());

                dd($e->getMessage());
            }

        }// foreach

    }//collection rows


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
