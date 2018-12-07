<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\ManufacturerRepository;
class ManufacturersImport implements ToCollection,WithChunkReading,ShouldQueue
{

    private $manufacturer;
    private $info;

    public function __construct(
        ManufacturerRepository $manufacturer,
        $info

    ){
      $this->info = $info;
        $this->manufacturer = $manufacturer;
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
                $manufacturer_id=(int)$row[0];
                $name=(string)$row[1];
                $image=(string)$row[2];
                $options=null;
                // Search by id
                $manufacturer=$this->manufacturer->find($manufacturer_id);
                if (isset($this->info['folderpaht'])) {
                    if (isset($image) && !empty($image)) {
                        $picture = $this->info['folderpaht'] . 'manufacturer/' . $image;
                        $destination_path = 'assets/icommerce/manufacturer/' . $manufacturer_id . '.jpg';
                        $img = $this->saveimage($destination_path, $picture);
                        $options["mainimage"] = $img;
                    }
                } else {
                    if($manufacturer)
                    $options = $manufacturer->options;
                }
                $options=json_encode($options);
                $param = [
                  'id' => $manufacturer_id,
                  'name' => $name,
                  'options'=>$options
                ];
                if($manufacturer){
                  //Update
                  $this->manufacturer->update($manufacturer,  $param);
                  \Log::info('Update Manufacturer: '.$manufacturer->name);
                }else{
                  //Create
                  $newManufacturer = $this->manufacturer->create($param);
                  // Take id from excel
                  $newManufacturer->id = $param["id"];
                  $newManufacturer->save();
                  \Log::info('Create a Manufacturer: '.$param['name']);
                }
              }//if row!=id
            } catch (\Exception $e) {
                \Log::error($e);
                dd($e->getMessage());
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
