<?php

namespace Modules\Icommerce\Imports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Icommerce\Repositories\Option_ValueRepository;
use Modules\Icommerce\Entities\Option_Value;

// class CategoriesImport implements ToCollection,WithChunkReading,WithHeadingRow,ShouldQueue
class OptionValuesImport implements ToCollection,WithChunkReading,WithHeadingRow,ShouldQueue
{

    private $option_value;
    private $info;
    public function __construct(
        Option_ValueRepository $option_value,
        $info

    ){
        $this->option_value = $option_value;
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
                  //Fields in excel
                  $option_value_id=(int)$row->id;
                  $option_id=(int)$row->option_id;
                  $description=(string)$row->description;
                  $sort_order=(int)$row->sort_order;
                  //Type (text,background or image)
                  //Background (With hexadecimal code)
                  //End fields excel
                  //data
                  $param = [
                    'id' => $option_value_id,
                    'description'=>$description,
                    'option_id'=>$option_id,
                    'sort_order'=>$sort_order
                  ];
                  // Search by id
                  $option_value = $this->option_value->find($option_value_id);
                  if(!isset($row->type)){
                    //Default type: text
                    $param['type']="text";
                    $param['options']=json_encode(['text'=>$description]);
                  }else{
                    //Isset $row->type
                    $options=[];
                    $param['type']=$row->type;
                    if($row->type=="text"){
                      $param['options']=json_encode(['text'=>$description]);
                    }else if($row->type=="background"){
                      if(isset($row->background))
                        $param['options']=json_encode(['background'=>$row->background]);
                      else
                        $param['options']=json_encode(['background'=>'#000000']);
                    }else if($row->type=="image"){
                      if (isset($this->info['folderpaht'])) {
                        $picture = $this->info['folderpaht'] . 'option_values/' .$row->id.'.jpg';
                        if (\Storage::disk('publicmedia')->exists($picture)){
                          $destination_path = 'assets/icommerce/option_values/' . $row->id . '.jpg';
                          $img = $this->saveimage($destination_path, $picture);
                        }else
                          $img='modules/icommerce/img/product/default.jpg';
                        $options["image"] = $img;
                        $param['options']=json_encode($options);
                      }//folderpath
                    }//$row->type==image
                  }//else isset $row->type
                  if($option_value){
                    // Update
                    $this->option_value->update($option_value,  $param);
                    \Log::info('Update Option_value: '.$option_value->description);
                  }else{
                    // Create
                    $newOption = $this->option_value->create($param);
                    // Take id from excel
                    $newOption->id = $param["id"];
                    $newOption->save();
                    \Log::info('Create a Option_value: '.$param['description']);
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
