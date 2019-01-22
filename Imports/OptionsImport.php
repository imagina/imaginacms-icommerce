<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Icommerce\Entities\Option;

// class CategoriesImport implements ToCollection,WithChunkReading,WithHeadingRow,ShouldQueue
class OptionsImport implements ToCollection,WithChunkReading,WithHeadingRow,ShouldQueue
{

    private $option;
    private $info;
    public function __construct(
        OptionRepository $option,
        $info

    ){
        $this->option = $option;
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
                  $option_id=(int)$row->id;
                  $type=(string)$row->type;
                  $description=(string)$row->description;
                  $sort_order=(int)$row->sort_order;
                  $param = [
                    'id' => $option_id,
                    'description'=>$description,
                    'type'=>$type,
                    'sort_order'=>$sort_order
                  ];
                  if(isset($row->parent_id)){
                    $param['parent_id']=$row->parent_id;
                  }
                  // Search by id
                  $option = $this->option->find($option_id);
                  //data
                  if($option){
                    // Update
                    $this->option->update($option,  $param);
                    \Log::info('Update Option: '.$option->description);
                  }else{
                    // Create
                    $newOption = $this->option->create($param);
                    // Take id from excel
                    $newOption->id = $param["id"];
                    $newOption->save();
                    \Log::info('Create a Option: '.$param['description']);
                  }//if exist
                }//if isset option
            } catch (\Exception $e) {
                \Log::error($e);
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
