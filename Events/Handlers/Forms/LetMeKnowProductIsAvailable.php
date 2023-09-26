<?php

namespace Modules\Icommerce\Events\Handlers\Forms;

class LetMeKnowProductIsAvailable
{
    public function handle($event = null)
    {
        \Log::info('Icommerce: Evens|Handlers|Forms|LetMeKnowProductIsAvailable');

        $formRepository = app("Modules\Iforms\Repositories\FormRepository");
        $blockRepository = app("Modules\Iforms\Repositories\BlockRepository");
        $settingRepository = app("Modules\Setting\Repositories\SettingRepository");
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        $params = [
            'filter' => [
                'field' => 'system_name',
            ],
            'include' => [],
            'fields' => [],
        ];

        // Validation OrganizationId
        $organizationId = null;
        if (! is_null($event) && isset($event->organization)) {
            $organizationId = $event->organization->id;
            $params['filter']['organizationId'] = $organizationId;
        }

        $form = $formRepository->getItem('icommerce_let_me_know_when_product_is_available_form', json_decode(json_encode($params)));

        //Validation Form
        if (! isset($form->id)) {
            try {
                // Create Form
                $form = $formRepository->create([
                    'title' => trans('icommerce::forms.letMeKnowWhenProductIsAvailable.title'),
                    'system_name' => 'icommerce_let_me_know_when_product_is_available_form',
                    'active' => true,
                ]);

                // Create Block
                $block = $blockRepository->create([
                    'form_id' => $form->id,
                ]);

                // Create Field
                $this->createField($form->id, $block->id, 1, 'productName', true, trans('icommerce::forms.letMeKnowWhenProductIsAvailable.fields.productName'));

                // Create Field
                $this->createField($form->id, $block->id, 1, 'email', true, trans('icommerce::forms.letMeKnowWhenProductIsAvailable.fields.email'));

                // Create Setting
                $settingRepository->create([
                    'name' => 'icommerce::letMeKnowProductIsAvailableForm',
                    'plainValue' => $form->id,
                    'isTranslatable' => 0,
                ]);
            } catch(\Exception $e) {
                \Log::error('Icommerce: Events|Handlers|Forms|LetMeKnowProductIsAvailable|Message: '.$e->getMessage());
                dd($e);
            }
        }

        \Log::info('Icommerce: Evens|Handlers|Forms|LetMeKnowProductIsAvailable|END');
    }// If handle

    /*
    * Create Field
    */
    public function createField($formId, $blockId, $type, $name, $required, $transLabel)
    {
        $fieldRepository = app("Modules\Iforms\Repositories\FieldRepository");

        $dataToCreate = [
            'form_id' => $formId,
            'block_id' => $blockId,
            'type' => $type,
            'name' => $name,
            'required' => $required,
        ];

        // Create Field
        $fieldCreated = $fieldRepository->create($dataToCreate);

        //Translations
        $this->addTranslation($fieldCreated, 'es', $transLabel, [], 'es');
        $this->addTranslation($fieldCreated, 'en', $transLabel, [], 'en');
    }

    /*
    * Add Translations
    * PD: New Alternative method due to problems with astronomic translatable
    **/
    public function addTranslation($field, $locale, $label)
    {
        \DB::table('iforms__field_translations')->insert([
            'label' => trans($label, [], $locale),
            'field_id' => $field->id,
            'locale' => $locale,
        ]);
    }
}
