<?php

namespace Modules\Icommerce\Entities;

/**
 * Class Status
 * @package Modules\icommerce\Entities
 */
class CartStatus
{
    const ABANDONED = 0;
    const ACTIVE = 1;
    const PROCESSED = 2;

    /**
     * @var array
     */
    private $statuses;

    public function __construct()
    {
        $this->statuses = [
            self::ABANDONED => trans('icommerce::carts.status.abandoned'),
            self::ACTIVE => trans('icommerce::carts.status.active'),
            self::PROCESSED => trans('icommerce::carts.status.processed'),
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

        return $this->statuses[self::ABANDONED];
    }
}
