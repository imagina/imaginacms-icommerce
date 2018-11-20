<?php

namespace Modules\Icommerce\Entities;

/**
 * Class Status
 * @package Modules\icommerce\Entities
 */
class Order_Status
{

    const PROCESSING = 0;
    const SHIPPED = 1;
    const CANCELED = 2;
    const COMPLETED = 3;
    const DENIED = 4;
    const CANCELEDREVERSAL= 5;
    const FAILED = 6;
    const REFUNDED= 7;
    const REVERSED = 8;
    const CHARGEBACK = 9;
    const PENDING = 10;
    const VOIDED = 11;
    const PROCESSED= 12;
    const EXPIRED = 13;
    
    /**
     * @var array
     */
    private $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::PROCESSING => trans('icommerce::order_status.processing'),
            self::SHIPPED => trans('icommerce::order_status.shipped'),
            self::CANCELED => trans('icommerce::order_status.canceled'),
            self::COMPLETED => trans('icommerce::order_status.completed'),
            self::DENIED => trans('icommerce::order_status.denied'),
            self::CANCELEDREVERSAL => trans('icommerce::order_status.canceledreversal'),
            self::FAILED => trans('icommerce::order_status.failed'),
            self::REFUNDED => trans('icommerce::order_status.refunded'),
            self::REVERSED => trans('icommerce::order_status.reserved'),
            self::CHARGEBACK => trans('icommerce::order_status.chargeback'),
            self::PENDING => trans('icommerce::order_status.pending'),
            self::VOIDED => trans('icommerce::order_status.voided'),
            self::PROCESSED => trans('icommerce::order_status.processed'),
            self::EXPIRED => trans('icommerce::order_status.expired'),
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
