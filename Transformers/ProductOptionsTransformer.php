<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductOptionsTransformer extends Resource
{
    public function toArray($request)
    {
        $option_values=[];
        if(isset($this->product_option_values) && !empty($this->product_option_values)){
          foreach($this->product_option_values as $option_value){
            $options_value_options=json_decode($option_value->option_value->options);
            //Opt value
            if((int)$option_value->product_id==(int)$this->pivot->product_id){
              //If opt_value->options->image
              if (isset($options_value_options->image) && !empty($options_value_options->image)) {
                $options_value_options->image = url($options_value_options->image);
              }
              //Default option value
              $price=0;
              $price_prefix="+";
              $quantity=0;
              $subtract=0;
              $weight=0;
              $weight_prefix="+";
              //Children Options
              $children_option=[];
              $child_description=null;
              $child_option_description=null;
              $child_option_id=null;
              $child_option=null;
              $child_option_type=null;
              if($option_value->children_option_value_id!=0 && $option_value->child_option_value){
                $child_option_description = $option_value->child_option_value->option->description;
                $child_option_id=$option_value->child_option_value->option->id;
                $child_description=$option_value->child_option_value->description;
                $child_option_type=$option_value->child_option_value->type;
                //Decode option
                $child_option=json_decode($option_value->child_option_value->options);
                  if (isset($child_option->image) && !empty($child_option->image)) {
                    $child_option->image = url($child_option->image);
                  }
                $children_option[]=[
                  'id'=>$option_value->children_option_value_id,
                  'product_option_value_id'=>$option_value->id,
                  'description'=>$child_description,
                  'option'=>$child_option,
                  'type'=>$child_option_type,
                  'option_id'=>$child_option_id,
                  'option_description'=>$child_option_description,
                  'price' => $option_value->price,
                  'price_prefix' => $option_value->price_prefix,
                  'quantity'=>$option_value->quantity,
                  'subtract'=>$option_value->subtract,
                  'weigth'=>$option_value->weight,
                  'weight_prefix'=>$option_value->weight_prefix
                ];
              }//option value
              else{
                //No children option values
                $price=$option_value->price;
                $price_prefix=$option_value->price_prefix;
                $quantity=$option_value->quantity;
                $subtract=$option_value->subtract;
                $weight=$option_value->weight;
                $weight_prefix=$option_value->weight_prefix;
              }//else
              if(count($option_values)==0){
                //Primer option value:
                //Make array option_value
                $option_values[]=[
                  'id'=>$option_value->option_value_id,
                  'description'=>$option_value->option_value->description,
                  'option'=>$options_value_options,
                  'product_option_value_id'=>$option_value->id,
                  'type'=>$option_value->option_value->type,
                  'option_id'=>$option_value->option_id,
                  'product_option_id'=>$option_value->product_option_id,
                  'child_option_description'=>$child_option_description,
                  'children_option_values'=>$children_option,
                  'price' => $price,
                  'price_prefix' => $price_prefix,
                  'quantity'=>$quantity,
                  'subtract'=>$subtract,
                  'weigth'=>$weight,
                  'weight_prefix'=>$weight_prefix
                ];
              }else{
                //If have rows array option values
                $f=0;//flag
                foreach($option_values as &$optValue){
                  if($optValue['id']==$option_value->option_value_id){
                    $f=1;//Exist
                    $children_option=[];
                    $child_description=null;
                    $child_option_description=null;
                    $child_option_id=null;
                    $child_option=null;
                    $child_option_type=null;
                    if($option_value->children_option_value_id!=0  && $option_value->child_option_value){
                      $child_option_type=$option_value->child_option_value->type;
                      $child_option_description=$option_value->child_option_value->option->description;
                      $child_option_id=$option_value->child_option_value->option->id;
                      $child_description=$option_value->child_option_value->description;
                      $child_option=json_decode($option_value->child_option_value->options);
                      if (isset($child_option->image) && !empty($child_option->image)) {
                        $child_option->image = url($child_option->image);
                      }
                      $children_option=[
                        'id'=>$option_value->children_option_value_id,
                        'product_option_value_id'=>$option_value->id,
                        'description'=>$child_description,
                        'type'=>$child_option_type,
                        'option'=>$child_option,
                        'option_id'=>$child_option_id,
                        'option_description'=>$child_option_description,
                        'price' => $option_value->price,
                        'price_prefix' => $option_value->price_prefix,
                        'quantity'=>$option_value->quantity,
                        'subtract'=>$option_value->subtract,
                        'weigth'=>$option_value->weight,
                        'weight_prefix'=>$option_value->weight_prefix
                      ];
                    }//option value
                    if(count($children_option)>0)
                      $optValue['children_option_values'][]=$children_option;
                  }
                }//foreach option_Values
                if($f==0){
                  $option_values[]=[
                    'id'=>$option_value->option_value_id,
                    'description'=>$option_value->option_value->description,
                    'option'=>$options_value_options,
                    'product_option_value_id'=>$option_value->id,
                    'type'=>$option_value->option_value->type,
                    'option_id'=>$option_value->option_id,
                    'product_option_id'=>$option_value->product_option_id,
                    'child_option_description'=>$child_option_description,
                    'children_option_values'=>$children_option,
                    'price' => $price,
                    'price_prefix' => $price_prefix,
                    'quantity'=>$quantity,
                    'subtract'=>$subtract,
                    'weigth'=>$weight,
                    'weight_prefix'=>$weight_prefix
                  ];
                }//f==0
              }// $option_Vaues >0 else
            }//if product option value == product option pivot
          }//foreach
        }//isset
        return  [
            'option_id' => $this->id,
            'required' => $this->pivot->required,
            'type' => $this->type,
            'description' => $this->description,
            'value'=>$this->pivot->value,
            'option_product_id'=>$this->pivot->product_id,
            'product_option_id'=>$this->pivot->id,
            'option_values'=>$option_values
        ];
    }
}
