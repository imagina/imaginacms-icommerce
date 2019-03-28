<?php

namespace Modules\Icommerce\Presenters;

use Laracasts\Presenter\Presenter;


class CartPresenter extends Presenter
{
    public function total()
    {
        return $this->sum('subtotal');
    }

}
