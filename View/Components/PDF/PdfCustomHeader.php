<?php

namespace Modules\Icommerce\View\Components\PDF;

use Illuminate\View\Component;

class PdfCustomHeader extends Component
{
  public $pdfcustomheader;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct()
  {

    $this->pdfcustomheader = setting("icommerce::addresses", null, "[]");

  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view("isite::frontend.components.contact.contactaddresses");
  }
}
