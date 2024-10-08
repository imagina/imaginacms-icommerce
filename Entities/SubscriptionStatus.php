<?php

namespace Modules\Icommerce\Entities;


class SubscriptionStatus
{
  const PENDING = 0;
  const ACTIVE = 1;
  const EXPIRED = 2;
  const SUSPENDED = 3;
  const CANCELLED = 4;
  const FAILED = 5;
  const DENIED = 6;
  const PAYMENT_PENDING = 7;

  /**
   * @var array
   */
  private $statuses = [];

  public function __construct()
  {
    $this->statuses = [
      self::PENDING => trans('icommerce::subscriptions.status.pending'),
      self::ACTIVE => trans('icommerce::subscriptions.status.active'),
      self::EXPIRED => trans('icommerce::subscriptions.status.expired'),
      self::SUSPENDED => trans('icommerce::subscriptions.status.suspended'),
      self::CANCELLED => trans('icommerce::subscriptions.status.cancelled'),
      self::FAILED => trans('icommerce::subscriptions.status.failed'),
      self::DENIED => trans('icommerce::subscriptions.status.denied'),
      self::PAYMENT_PENDING => trans('icommerce::subscriptions.status.paymentPending')
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

    return $this->statuses[self::PENDING];
  }
}
