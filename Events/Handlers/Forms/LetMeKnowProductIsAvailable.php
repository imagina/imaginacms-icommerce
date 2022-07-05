<?php

namespace Modules\Icommerce\Events\Handlers\Forms;


class LetMeKnowProductIsAvailable
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

        // Validation OrganizationId
        $organizationId = null;
        if(!is_null($event) && isset($event->organization)){
            $organizationId = $event->organization->id;
            $params["filter"]["organizationId"] = $organizationId;
        }

        $form = $formRepository->getItem("icommerce_let_me_know_when_product_is_available_form", json_decode(json_encode($params)));

        //Validation Form
        if(!isset($form->id)) {

            // Create Form
            $form = $formRepository->create([
                "title" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.title"),
                "system_name" => "icommerce_let_me_know_when_product_is_available_form",
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
                  "label" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.fields.productName",[],"es"),
                ],
                "en" => [
                  "label" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.fields.productName",[],"en"),
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
                  "label" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.fields.email",[],"es"),
                ],
                "en" => [
                  "label" => trans("icommerce::forms.letMeKnowWhenProductIsAvailable.fields.email",[],"en"),
                ],
                "type" => 1,
                "name" => "email",
                "required" => true,
            ]);

            // Create Setting
            $settingRepository->create([
                "name" => "icommerce::letMeKnowProductIsAvailableForm",
                "plainValue" => $form->id,
                "isTranslatable" => 0
            ]);
            
        }
        
    }// If handle

}
