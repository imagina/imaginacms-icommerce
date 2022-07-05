<?php

namespace Modules\Icommerce\Events\Handlers\Forms;


class Quote
{
   

    public function handle($event = null)
    {

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

        // Validation Organization
        $organizationId = null;
        if(!is_null($event) && isset($event->organization)){
            $organizationId = $event->organization->id;
            $params["filter"]["organizationId"] = $organizationId;
        }

        $form = $formRepository->getItem("icommerce_quote_form", json_decode(json_encode($params)));

        if(!isset($form->id)) {
          
          //Create Form
          $form = $formRepository->create([
            "title" => trans("icommerce::quote.form.form.title.single"),
            "system_name" => "icommerce_quote_form",
            "active" => true
          ]);
      
          // Create Block
          $block = $blockRepository->create([
            "form_id" => $form->id
          ]);
          
          // Create Field
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

          // Create Field
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
      
          // Create Field
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

          // Create Field
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
      
          // Create Field
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

          // Create Setting
          $settingRepository->create([
            "name" => "icommerce::icommerceQuoteForm",
            "plainValue" => $form->id,
            "isTranslatable" => 0
          ]);
          
        }
        
    }// If handle

}
