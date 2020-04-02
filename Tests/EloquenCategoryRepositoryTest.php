<?php

namespace Modules\Icommerce\Tests;

class EloquenCategoryRepositoryTest extends BaseIcommerceTestCase
{

  /** @test */
  public function it_can_create_category()
  {

    /* Create row in table categories */
    $category = $this->createCategory();

    /* Make the assertion to verify that the record was created */
    $this->assertTrue(isset($category->id));
  }

  /** @test */
  public function it_can_update_category()
  {

    /* Create row in table categories */
    $category = $this->createCategory();

    /* Update row */
    $data = [
      'slug' => 'imagina-colombia-updated'
    ];
    $category->update($data);

    /* Make the assertion to verify that the record was updated */
    $this->assertTrue($category->slug == 'imagina-colombia-updated');
  }

  /** @test */
  public function it_can_get_item()
  {
    // To do
    $this->assertTrue(true);
  }


  /** @test */
  public function it_can_get_items_by()
  {
    // To do
    $this->assertTrue(true);
  }

}
