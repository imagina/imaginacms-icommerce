<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class IformRequestQuoteTableSeeder extends Seeder
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
    $form = $formRepository->getItem("icommerce_cart_quote_form", json_decode(json_encode($params)));
    if(!isset($form->id)) {

      $form = $formRepository->create([
        "title" => trans("icommerce::quote.form.form.title.complex"),
        "system_name" => "icommerce_cart_quote_form",
        "active" => true
      ]);

      $block = $blockRepository->create([
        "form_id" => $form->id
      ]);

      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.productForm.fields.firstName.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.productForm.fields.firstName.label",[],"en"),
        ],
        "type" => 1,
        "name" => "first_name",
        "required" => true,
      ]);


      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.productForm.fields.lastName.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.productForm.fields.lastName.label",[],"en"),
        ],
        "type" => 1,
        "name" => "last_name",
        "required" => true,
      ]);

      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.productForm.fields.email.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.productForm.fields.email.label",[],"en"),
        ],
        "type" => 4,
        "name" => "email",
        "required" => true,
      ]);

      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.productForm.fields.telephone.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.productForm.fields.telephone.label",[],"en"),
        ],
        "type" => 10,
        "name" => "telephone",
        "required" => true,
      ]);

      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.productForm.fields.additionalInformation.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.productForm.fields.additionalInformation.label",[],"en"),
        ],
        "type" => 2,
        "name" => "additional_information",
        "required" => true,
      ]);
      $settingRepository->createOrUpdate(["icommerce::icommerceCartQuoteForm" =>  $form->id]);
    }

  }
}
