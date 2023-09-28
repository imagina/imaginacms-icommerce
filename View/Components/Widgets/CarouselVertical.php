<?php

namespace Modules\Icommerce\View\Components\Widgets;

use Illuminate\View\Component;

class CarouselVertical extends Component
{
    public $id;

    public $title;

    public $isExpanded;

    public $props;

    public $view;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title = '', $isExpanded = false, $props = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->isExpanded = $isExpanded;
        $this->props = $props;
        $this->view = 'icommerce::frontend.components.widgets.carousel-vertical';
    }

    public function render()
    {
        return view($this->view);
    }
}
