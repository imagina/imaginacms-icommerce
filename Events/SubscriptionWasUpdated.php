<?php

namespace Modules\Icommerce\Events;

class SubscriptionWasUpdated
{
    public $params;

    public function __construct($params = null)
    {
        $this->params = $params;
    }
}
