<?php

namespace Modules\Icommerce\Events;

class SubscriptionWasCreated
{
    public $params;

    public function __construct($params = null)
    {
        $this->params = $params;
    }
}
