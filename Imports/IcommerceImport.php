<?php

namespace Modules\Icommerce\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\Icommerce\Imports\CategoriesImport;
use Modules\Icommerce\Imports\ManufacturersImport;
use Modules\Icommerce\Imports\ProductsImport;
use Modules\Icommerce\Imports\OptionsImport;
use Modules\Icommerce\Imports\OptionValuesImport;
use Modules\Icommerce\Imports\ProductOptionImport;
use Modules\Icommerce\Imports\ProductOptionValuesImport;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Icommerce\Repositories\Option_ValueRepository;
use Modules\Icommerce\Repositories\Product_OptionRepository;
use Modules\Icommerce\Repositories\Product_Option_ValueRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

// class IcommerceImport implements WithMultipleSheets,WithChunkReading,ShouldQueue {
class IcommerceImport implements WithMultipleSheets,WithChunkReading,ShouldQueue {

    private $category;
    private $manufacturer;
    private $product;
    private $info;
    private $option;
    private $option_value;
    private $productOption;
    private $productOptionValue;
    public function __construct(
      ProductRepository $product,
        CategoryRepository $category,
        ManufacturerRepository $manufacturer,
        OptionRepository $option,
        Option_ValueRepository $option_value,
        Product_OptionRepository $productOption,
        Product_Option_ValueRepository $productOptionValue,
        $info
    ){
        $this->category = $category;
        $this->product = $product;
        $this->manufacturer = $manufacturer;
        $this->option = $option;
        $this->option_value = $option_value;
        $this->productOption = $productOption;
        $this->productOptionValue = $productOptionValue;
        $this->info=$info;
    }

    public function sheets(): array
    {
        return [
            'Categories' => new CategoriesImport($this->category,$this->info),
            'manufactures' => new ManufacturersImport($this->manufacturer,$this->info),
            'Products'=>new ProductsImport($this->product,$this->info),
            'Options'=>new OptionsImport($this->option,$this->info),
            'Option_Values'=>new OptionValuesImport($this->option_value,$this->info),
            'Product_Option'=>new ProductOptionImport($this->productOption,$this->info),
            'Product_Option_Values'=>new ProductOptionValuesImport($this->productOptionValue,$this->info),
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
