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
    $data = [
      'en' => [

      ],
      'es' => [

      ],

    ];

    return $this->product->create($data);
  }
}
