<?php

namespace Modules\Icommerce\Presenters;

//use Laracasts\Presenter\Presenter;


class TotalcartPresenter extends Presenter
{
    public function GetSubTotal($item)
    {
        return $item->sum('subtotal');
    }

}
