<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class IformLetMeKnowWhenProductIsAvailableTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $formRepository = app("Modules\Iforms\Repositories\FormRepository");
    $blockRepository = app("Modules\Iforms\Repositories\BlockRepository");
    $fieldRepository = app("Modules\Iforms\Repositories\FieldRepository");
    $settingRepository = app("Modules\Setting\Repositories\SettingRepository");
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
    $params = [
      "filter" => [
        "field" => "system_name",
      ],
      "include" => [],
      "fields" => [],
    ];
    $form = $formRepository->getItem("icommerce_let_me_know_when_product_is_available_form", json_decode(json_encode($params)));
    if(!isset($form->id)) {

      $form = $formRepository->create([
        "title" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.title"),
        "system_name" => "icommerce_let_me_know_when_product_is_available_form",
        "active" => true
      ]);

      $block = $blockRepository->create([
        "form_id" => $form->id
      ]);

      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.fields.productName",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.fields.productName",[],"en"),
        ],
        "type" => 1,
        "name" => "productName",
        "required" => true,
      ]);


      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.fields.email",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.fields.email",[],"en"),
        ],
        "type" => 1,
        "name" => "email",
        "required" => true,
      ]);

      $settingRepository->createOrUpdate(["icommerce::letMeKnowProductIsAvailableForm" =>  $form->id]);
    }

  }
}
