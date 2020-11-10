<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Entities\Category;

// class CategoriesImport implements ToCollection,WithChunkReading,WithHeadingRow,ShouldQueue
class CategoriesImport implements ToCollection, WithChunkReading, WithHeadingRow
{

    private $category;
    private $info;

    public function __construct(
        CategoryRepository $category,
        $info

    ){
        $this->category = $category;
        $this->info = $info;
    }

    /**
     * Data from Excel
     */
    public function collection(Collection $rows)
    {
        \App::setLocale($this->info['Locale']);
        $rows = json_decode(json_encode($rows));
        // dd($rows);
        foreach ($rows as $row) {
            try {
                if (isset($row->id)) {
                    $category_id = (int)$row->id;
                    $title = (string)$row->title;
                    $description = (string)$row->description;
                    $parent_id = (int)$row->parent_id;
                    $image = (string)$row->image;
                    $slug = "";
                    // Search by id
                    $category = $this->category->find($category_id);
                    $slug = Str::slug($title, '-');

                    //data
                    $param = [
                        'id' => $category_id,
                        'slug' => $slug,
                        'title' => $title,
                        'description' => $description,
                        'parent_id'=>$parent_id,
                    ];

                    if (isset($category->id) && !empty($category->id)) {
                        // Update
                        $this->category->update($category, $param);
                        \Log::info('Update Category: '.$category->id.' title: ' . $category->title);
                    } else {
                        // Create
                        $category = $this->category->create($param);
                        \Log::info('Create a Category: '.$category->id.' title: ' .  $category->title);
                    }//if exist

                    if (isset($image) && !empty($image)) {

                        $item = DB::table('media__files')->select('id')->where('filename', $image)->first();
                        if (isset($item->id)) {
                            $imageselec = DB::table('media__imageables')->select('id')->where('file_id', $item->id)->where('imageable_id', $category->id)->where('imageable_type', 'Modules\Icommerce\Entities\Category')->where('zone', 'mainimage')->first();
                            if (!isset($imageselec->id)) {
                                DB::insert('insert into media__imageables (file_id, imageable_id, imageable_type, zone) values (?, ?, ?, ?)', [$item->id, $category->id, 'Modules\Icommerce\Entities\Category', 'mainimage']);
                            }


                        }

                    }



                }//if isset title
            } catch (\Exception $e) {
                \Log::error($e);
                // dd($e->getMessage());
            }

        }// foreach

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
