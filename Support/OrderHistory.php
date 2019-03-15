<?php

namespace Modules\Icommerce\Support;

class OrderHistory
{

  private $status;
  private $notify;
  private $comment;

  public function __construct($status,$notify,$comment=null){

    $this->status = $status;
    $this->notify = $notify;

  }

   
  public function getData(){

    $data = array(
      'status' => $this->status, 
      'notify' => $this->notify,
      'comment' => $this->comment
    );

    return $data;

  }

}