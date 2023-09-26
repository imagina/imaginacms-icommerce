<?php

namespace Modules\Icommerce\Presenters;

use Laracasts\Presenter\Presenter;

class CartproductPresenter extends Presenter
{
    public function subtotal()
    {
        return $this->price * $this->quantity;
    }
}
