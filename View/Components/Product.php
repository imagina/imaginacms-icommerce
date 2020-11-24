<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class Product extends Component
{


    public $product;
    public $mainLayout;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product,$mainLayout=null ) 
    {
        $this->product = $product;
        $this->mainLayout = $mainLayout;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {

        if(isset($this->mainLayout) && $this->mainLayout=='one'){
            $view = 'icommerce::frontend.components.product.layout-one';
        }else{
            $base = setting('icommerce::productLayouts', null, 'product-layout-1');
            $view = "icommerce::frontend.components.product.layouts.".$base;
        }

        return view($view);
    }
}