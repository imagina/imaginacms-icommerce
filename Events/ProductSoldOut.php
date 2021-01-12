<?php

namespace Modules\Icommerce\Events;

class ProductSoldOut
{
    public $mails;
    public $product;
    
    // this attribute it's required
    public $entity;

    /**
     * Create a new event instance.
     *
     * @param $entity
     * @param array $data
     */
    public function __construct($mails,$product)
    {
        $this->mails = $mails;
        $this->entity = $product;
        $this->product = $product;
    }
  
  // this method it's required
  
  public function notification(){
    
    return [
      "title" =>  "",
      "message" =>   "",
      "icon_class" => "fas fa-glass-cheers",
      "link" => "link",
      "view" => "iteam::emails.userJoined.userJoined",
      "recipients" => [
        "email" => [$this->mails],
        //"broadcast" => [$this->user->id],
        //"push" => [$this->user->id],
      ],
      
      // here you can send all objects and params necessary to the view template
      "product" => $this->product
    ];
  }

}

