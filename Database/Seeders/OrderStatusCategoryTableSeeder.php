<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\OrderStatus;


class OrderStatusCategoryTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $orderStatusCategory = config('asgard.icommerce.config.orderStatusCategory');

    foreach ($orderStatusCategory as $categoryData){
      //Check Categories
      $category = $this->checkCategory($categoryData);
      //Check statuses for this category
      foreach ($categoryData['statuses'] as $key => $statusData) {
        $this->checkStatus($category->id,$statusData);
      }

    }

  }

  /**
   * Check if exist category | Create Category
   */
  private function checkCategory($categoryData)
  {

    $categoryRepository = app('Modules\Icommerce\Repositories\OrderStatusCategoryRepository');

    //Search Category
    $params = ["filter" => ["field" => "type"],"include" => [], "fields" => []];
    $existCategory = $categoryRepository->getItem($categoryData["type"], json_decode(json_encode($params)));

    if(is_null($existCategory)){

      //Create Category
      $category = $categoryRepository->create([
        'type' => $categoryData["type"],
        'internal' => $categoryData["internal"] ?? 1
      ]);

      //Create Translations
      $this->createCategoryTranslations($categoryData["title"],$category);

      return $category;

    }else{

      return $existCategory;
    }

  }

  /**
  * add translations to category
  */
  private function createCategoryTranslations($title,$category)
  {

    $translations = [
        ['locale' => 'es','title' => trans($title, [], 'es')],
        ['locale' => 'en','title' => trans($title, [], 'en')]
    ];

    foreach ($translations as $translation) {
        \DB::table('icommerce__order_status_category_translations')->insert([
            'title' => $translation['title'],
            'order_status_category_id' => $category->id,
            'locale' => $translation['locale']
        ]);
    }

  }

  /**
   * Check Order Status and Update with new attributes
   */
  private function checkStatus($categoryId,$statusData)
  {

    $orderStatusRepository = app('Modules\Icommerce\Repositories\OrderStatusRepository');

    //Get Order Status
    $orderStatus = $orderStatusRepository->getItem($statusData['id']);

    //The new attributes for the OrderStatus have not been updated yet.
    if($orderStatus && is_null($orderStatus->category_id)){

      $newData = [
        'category_id' => $categoryId,
        'type' => $statusData['type'],
        'color' => $statusData['color'],
      ];

      //Optional Data
      $newData = array_merge($newData, array_filter([
          'default' => $statusData['default'] ?? null,
          'final' => $statusData['final'] ?? null,
      ]));

      //Update with new attributes
      $orderStatus->update($newData);

    }


  }

}
