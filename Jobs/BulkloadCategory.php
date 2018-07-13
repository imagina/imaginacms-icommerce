<?php

namespace Modules\Icommerce\Jobs;

use Couchbase\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Icommerce\Entities\Category;

class BulkloadCategory implements ShouldQueue
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
            $model= new Category();
            foreach ($this->data as $category) {
                if (isset($category->title)) {
                    $category->options = null;
                    $exist = $model->find($category->id);
                    //order file
                    if (isset($this->info['folderpaht'])) {
                        if (isset($category->image) && !empty($category->image)) {
                            $picture = $this->info['folderpaht'] . 'categories/' . $category->image;
                            $destination_path = 'assets/icommerce/category/' . $category->id . '.jpg';
                            $img = $this->saveimage($destination_path, $picture);
                            $category->options = ["mainimage" => $img];
                            \Log::info($category->options);
                        }

                    } else {
                        $category->options = $exist->options;
                    }
                    if ($category->parent_id == 0) {
                        $slug = str_slug($category->title, '-');
                    } else {
                        $parent = $model->find($category->parent_id);
                        $slug = $parent->slug . '/' . str_slug($category->title, '-');
                    }
                    $category->options = json_encode($category->options);

                    if ($exist) {
                        $model = $exist;
                        \Log::info('Update entity');
                    } else {
                        \Log::info('create entity');
                        $model = new Category();
                        $model->id = $category->id;
                    }

                    $model->title = $category->title??$exist->title;
                    $model->slug = $slug;
                    $model->description = $category->description ?? $exist->decription??'';
                    $model->parent_id = $category->parent_id ?? 0;
                    $model->options = $category->options;
                    $model->save();

                    \Log::info($model);
                }
            }
        } catch (\Exception $e) {

            \Log::error($e->getMessage());

            dd($e, $category, $model);

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
