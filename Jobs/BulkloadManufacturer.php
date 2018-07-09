<?php

namespace Modules\Icommerce\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Icommerce\Entities\Manufacturer;

class BulkloadManufacturer implements ShouldQueue
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
            $model = new Manufacturer();
            foreach ($this->data as $manufacturer) {
                $exist = $model->find($manufacturer->id);
                //order file
                $manufacturer->options = null;
                if (isset($this->info['folderpaht'])) {

                    if (isset($manufacturer->image) && !empty($manufacturer->image)) {
                        $picture = $this->info['folderpaht'] . 'manufacturer/' . $manufacturer->image;
                        $destination_path = 'assets/icommerce/manufacturer/' . $manufacturer->id . '.jpg';
                        $img = $this->saveimage($destination_path, $picture);
                        $manufacturer->options["mainimage"] = $img;
                    }
                    if (isset($manufacturer->catalog) && !empty($manufacturer->catalog)) {
                        $catalogfile = $this->info['folderpaht'] . 'manufacturer/catalog/' . $manufacturer->catalog;
                        if (\Storage::disk('publicmedia')->exists($catalogfile)) {
                            $destination_path = 'assets/icommerce/manufacturer/mediafile/' . $manufacturer->id . '.pdf';
                            $catalog = $this->saveFile($catalogfile, $destination_path);
                            $manufacturer->options["catalog"] = $catalog;
                            \Log::error($manufacturer->options);
                        }
                    }
                    if (isset($manufacturer->datasheet) && !empty($manufacturer->datasheet)) {
                        $datasheetfile = $this->info['folderpaht'] . 'manufacturer/datasheet/' . $manufacturer->image;
                        if (\Storage::disk('publicmedia')->exists($datasheetfile)) {
                            $destination_path = 'assets/icommerce/manufacturer/mediafile/' . $manufacturer->id . '.pdf';
                            $datasheet = $this->saveFile($datasheetfile, $destination_path);
                            $manufacturer->options["mediafile"] = $datasheet;
                            \Log::error($manufacturer->options);
                        }

                    }
                } else {
                    $manufacturer->options = $exist->options;
                }
                \Log::error($manufacturer->options);
                $manufacturer->options = json_encode(json_encode($manufacturer->options));


                if ($exist) {
                    $model = $exist;
                    \Log::info('Update entity');
                } else {
                    \Log::info('create entity');
                    $model = new Manufacturer();
                    $model->id = $manufacturer->id;
                }

                $model->name = $manufacturer->name??$exist->name;
                $model->options = $manufacturer->options;
                $model->save();
                \Log::info($model);
            }
        } catch (\Exception $e) {

            \Log::error($e->getMessage());

            dd($e, $manufacturer, $model);

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
