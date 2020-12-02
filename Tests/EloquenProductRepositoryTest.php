<?php

namespace Modules\Icommerce\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EloquenProductRepositoryTest extends BaseIcommerceTestCase
{

  protected $product;

  public function setUp()
  {
    parent::setUp();
    $this->product = app('Modules\Icommerce\Repositories\ProductRepository');
  }

  /** @test */
  public function it_work()
  {
    $product = $this->createProduct();

    $this->assertTrue(isset($product->id));
  }

  public function createProduct()
  {

    // Create 10 fake categories
    $categories = [];
    for ($i = 0; $i < 10; $i++){
      $categories[] = $this->createCategory()->id;
    }

    // Create 10 fake options
    $options = [];
    for ($i = 0; $i < 10; $i++){
      $options[] = [
        'id' => $this->createOption()->id,
        'required' => false,
      ];
    }

    $data = [
      'added_by_id' => 1,
      'options' => [],
      'status' => 1,
      'category_id' => 1,
      'parent_id' => 0,
      'tax_class_id' => null,
      'sku' => '123456789',
      'quantity' => 1000,
      'stock_status' => 1,
      'manufacturer_id' => null,
      'shipping' => 1,
      'price' => 1500,
      'points' => 10,
      'date_available' => '2020-01-01',
      'weight' => 0,
      'length' => 0,
      'width' => 0,
      'height' => 0,
      'subtract' => 1,
      'minimum' => 10,
      'reference' => null,
      'rating' => 3,
      'freeshipping' => 1,
      'order_weight' => 0,
      'store_id' => null,
      'es' => [
        'name' => 'product test',
        'description' => 'this is a product for unit testing',
        'summary' => 'The product test is a good product',
        'slug' => 'product-test',
        'meta_title' => 'product test',
        'meta_description' => 'this is a product for unit testing',
      ],
      'categories' => $categories,
      'product_options' => $options,
  /*    'option_values' => [

      ],
      'related_products' => [

      ],
      'discounts' => [

      ],
      'tags' => [

      ],*/
    ];

    return $this->product->create($data);
  }
}
