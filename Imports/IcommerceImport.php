<?php

namespace Modules\Icommerce\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\Icommerce\Imports\CategoriesImport;
use Modules\Icommerce\Imports\ManufacturersImport;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class IcommerceImport implements WithMultipleSheets,WithChunkReading,ShouldQueue {

    private $category;
    private $manufacturer;
    private $product;
    private $info;
    public function __construct(
      ProductRepository $product,
        CategoryRepository $category,
        ManufacturerRepository $manufacturer,
        $info
    ){
        $this->category = $category;
        $this->product = $product;
        $this->manufacturer = $manufacturer;
        $this->info=$info;
    }

    public function sheets(): array
    {
        return [
            'Categories' => new CategoriesImport($this->category,$this->info),
            'manufactures' => new ManufacturersImport($this->manufacturer,$this->info),
            'Products'=>new ProductsImport($this->product,$this->info)
        ];
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
