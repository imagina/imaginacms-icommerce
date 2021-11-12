<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class IformQuoteTableSeeder extends Seeder
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
    $form = $formRepository->getItem("icommerce_quote_form", json_decode(json_encode($params)));
    if(!isset($form->id)) {
      
      $form = $formRepository->create([
        "title" => trans("icommerce::quote.form.form.title.single"),
        "system_name" => "icommerce_quote_form",
        "active" => true
      ]);
  
      $block = $blockRepository->create([
        "form_id" => $form->id
      ]);
      
      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.form.fields.name.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.form.fields.name.label",[],"en"),
        ],
        "type" => 1,
        "name" => "fullName",
        "required" => true,
      ]);
  
      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.form.fields.email.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.form.fields.email.label",[],"en"),
        ],
        "type" => 4,
        "name" => "email",
        "required" => true,
      ]);
  
      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.form.fields.telephone.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.form.fields.telephone.label",[],"en"),
        ],
        "type" => 10,
        "name" => "telephone",
        "required" => true,
      ]);
      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.form.fields.productName.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.form.fields.productName.label",[],"en"),
        ],
        "type" => 1,
        "name" => "productName",
        "required" => true,
      ]);
  
      $fieldRepository->create([
        "form_id" => $form->id,
        "block_id" => $block->id,
        "es" => [
          "label" => trans("icommerce::quote.form.fields.additionalInformation.label",[],"es"),
        ],
        "en" => [
          "label" => trans("icommerce::quote.form.fields.additionalInformation.label",[],"en"),
        ],
        "type" => 2,
        "name" => "additionalInformation",
        "required" => true,
      ]);
      $settingRepository->createOrUpdate(["icommerce::icommerceQuoteForm" =>  $form->id]);
    }
    
  }
}
