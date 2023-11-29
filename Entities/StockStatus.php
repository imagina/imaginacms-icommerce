<?php

namespace Modules\Icommerce\Entities;

/**
 * Class Status
 * @package Modules\icommerce\Entities
 */
class StockStatus
{
  const OUTSTOCK = 0;
  const INSTOCK = 1;
  
  /**
   * @var array
   */
  private $statuses = [];
  
  public function __construct()
  {
    $this->statuses = [
      self::OUTSTOCK => trans('icommerce::stockStatus.outstock'),
      self::INSTOCK => trans('icommerce::stockStatus.instock'),
    ];
  }
  
  /**
   * Get the available statuses
   * @return array
   */
  public function lists()
  {
    return $this->statuses;
  }
  
  /**
   * Get the post status
   * @param int $statusId
   * @return string
   */
  public function get($statusId)
  {
    if (isset($this->statuses[$statusId])) {
      return $this->statuses[$statusId];
    }
    
    return $this->statuses[self::OUTSTOCK];
  }
}
