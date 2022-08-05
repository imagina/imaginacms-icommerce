<?php

namespace Modules\Icommerce\Events\Handlers\Forms;


class Quote
{
   

    public function handle($event = null)
    {

        \Log::info("Icommerce: Evens|Handlers|Forms|Quote");

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
          
          try{

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
            $this->createField($form->id,$block->id,1,"fullName",true,trans("icommerce::quote.form.fields.name.label"));

            // Create Field
            $this->createField($form->id,$block->id,4,"email",true,trans("icommerce::quote.form.fields.email.label"));
        
            // Create Field
            $this->createField($form->id,$block->id,10,"telephone",true,trans("icommerce::quote.form.fields.telephone.label"));

            // Create Field
            $this->createField($form->id,$block->id,1,"productName",true,trans("icommerce::quote.form.fields.productName.label"));
        
            // Create Field
            $this->createField($form->id,$block->id,2,"additionalInformation",true,trans("icommerce::quote.form.fields.additionalInformation.label"));

            // Create Setting
            $settingRepository->create([
              "name" => "icommerce::icommerceQuoteForm",
              "plainValue" => $form->id,
              "isTranslatable" => 0
            ]);

          }catch(\Exception $e){
                \Log::error('Icommerce: Events|Handlers|Forms|Quote|Message: '.$e->getMessage());
                dd($e);
          }

          \Log::info("Icommerce: Evens|Handlers|Forms|Quote|END"); 
          
        }
        
    }// If handle

    /*
    * Create Field
    */
    public function createField($formId,$blockId,$type,$name,$required,$transLabel){
        
        $fieldRepository = app("Modules\Iforms\Repositories\FieldRepository");

        $dataToCreate = [
            "form_id" => $formId,
            "block_id" => $blockId,
            "type" => $type,
            "name" => $name,
            "required" => $required
        ];

        // Create Field
        $fieldCreated = $fieldRepository->create($dataToCreate);

        //Translations
        $this->addTranslation($fieldCreated,'es',$transLabel,[],"es");
        $this->addTranslation($fieldCreated,'en',$transLabel,[],"en");

    }


    /*
    * Add Translations
    * PD: New Alternative method due to problems with astronomic translatable
    **/
    public function addTranslation($field,$locale,$label){

      \DB::table('iforms__field_translations')->insert([
          'label' => trans($label,[],$locale),
          'field_id' => $field->id,
          'locale' => $locale
      ]);

    }

}
