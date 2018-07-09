<?php

namespace Modules\Icommerce\Jobs;

use Couchbase\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Icommerce\Entities\Product;

class BulkloadProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $info;
    /**
     * Create a new job instance.
     *
     * @param $data
     * @param $info
     * @Repositories ProductRepository $product
     */
    public function __construct($data, $info)
    {
        $this->data = $data;
        $this->info = $info;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            \App::setLocale($this->info['Locale']);
            $model = new Product();

            foreach ($this->data as $product) {

                \Log::info($product->id);
                if (isset($product->id)) {
                    $exist = $model->find($product->id);

                    $product->options = null;
                    if (isset($this->info['folderpaht'])) {
                        if (isset($product->image) && !empty($product->image)) {
                            $picture = $this->info['folderpaht'] . 'products/' . $product->image;
                            $destination_path = 'assets/icommerce/product/' . $product->id . '.jpg';
                            $img = $this->saveimage($destination_path, $picture);
                            $product->options["mainimage"] = $img;
                        }
                        if (isset($product->certificate) && !empty($product->certificate)) {
                            $certificatefile = $this->info['folderpaht'] . 'products/certificate/' . $product->certificate;

                            if (\Storage::disk('publicmedia')->exists($certificatefile)) {
                                $destination_path = 'assets/icommerce/product/certificate/' . $product->id . '.pdf';
                                $certificate = $this->saveFile($certificatefile, $destination_path);
                                $product->options["certificate"] = $certificate;
                            }

                        }
                        if (isset($product->datasheet) && !empty($product->datasheet)) {
                            $datasheetfile = $this->info['folderpaht'] . 'products/datasheet/' . $product->datasheet;
                            if (\Storage::disk('publicmedia')->exists($datasheetfile)) {
                                $destination_path = 'assets/icommerce/product/datasheet/' . $product->id . '.pdf';
                                $datasheet = $this->saveFile($datasheetfile, $destination_path);
                                $product->options["datasheet"] = $datasheet;
                            }

                        }
                        \Log::info(isset($product->options) ? $product->options :'null');
                    } else {

                        \Log::info('options no exist');
                        $product->options = $exist->options;
                    }
                    //order file
                    $product->options = json_encode($product->options);
                    $product->user_id = $this->info['user_id'];

                    if (isset($product->slug)) {
                        $slug = isset($product->slug) ? str_slug($product->slug, '-') : str_slug($exist->slug, '-');
                    } else {
                        $slug = isset($product->title) ? str_slug($product->title, '-') : str_slug($exist->title, '-');
                    }
                    if ($exist) {
                        $model = $exist;
                        \Log::info('Update entity');
                    } else {
                        \Log::info('create entity');
                        $model = new Product();
                        $model->id = $product->id;
                    }

                    $model->sku = $product->sku ?? $exist->sku;
                    $model->title =  $product->title ?? $exist->title;
                    $model->slug = $slug;
                    $model->description = $product->description ?? $exist->description;
                    $model->summary =  $product->summary ?? $exist->summary ?? substr(strip_tags($this->description),0,150);
                    $model->category_id = $product->category_id ?? $exist->category_id;
                    $model->quantity = $product->quantity ?? $exist->quantity ?? 0;
                    $model->status =  $product->status ?? $exist->status ?? 1;
                    $model->rating =  $product->rating ?? $exist->rating ?? '3';
                    $model->stock_status =  $product->stock_status ??  $exist->stock_status ?? 1;
                    $model->manufacter_id =  $product->manufacter_id ?? $exist->manufacter_id ?? null;
                    $model->price =  $product->price ?? $exist->price;
                    $model->date_available = $product->date_available ??  $exist->date_available ?? date('Y-m-d');
                    $model->weight =  $product->weight ??  $exist->weight ?? 0;
                    $model->lenght =  $product->lenght ??  $exist->lenght ?? 0;
                    $model->width =  $product->width ?? $exist->width ?? 0;
                    $model->height =  $product->height ?? $exist->height ?? 0;
                    $model->minimum = $product->minimum ??  $exist->minimum ?? 1;
                    $model->reference = $product->reference ?? $exist->reference ?? null;
                    $model->options =  $product->options ?? $exist->options;
                    $model->user_id =  $product->user_id ?? $exist->user_id;

                    $model->save();

                    \Log::info($model);

                    $prod = $model->find($product->id);

                    if (isset($product->categories)) {

                        $cats = explode('.', $product->categories);

                        $prod->categories()->sync($cats);
                        \Log::info($cats);
                    }

                }
            }
        } catch (\Exception $e) {

            \Log::error($e);

            dd($e->getMessage(), $product, $model);

        }
    }

    /**
     * The job failed to process.
     *
     * @param  Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        \Log::error($exception);
    }

    public function saveFile($oldfile, $newfile)
    {

        $disk = 'publicmedia';
        try {
            if (\File::exists($newfile)) {

                \File::delete($newfile);

                \Storage::disk($disk)->copy($oldfile, $newfile);

            } else {

                \Storage::disk($disk)->copy($oldfile, $newfile);
            }

            return $newfile;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $newfile;
        }

    }

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

}
