<?php

namespace Modules\Icommerce\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;

//Events
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

//Extra
use Modules\Notification\Services\Inotification;
use Modules\Icommerce\Entities\OrderItem;
use Modules\Icommerce\Transformers\OrderTransformer;

use Modules\Isite\Traits\ReportQueueTrait;

class OrdersExport implements FromQuery, WithEvents, ShouldQueue, WithMapping, WithHeadings
{
  use Exportable, ReportQueueTrait;

  private $params;
  private $exportParams;
  private $inotification;
  private $service;

  public function __construct($params, $exportParams)
  {
    $this->userId = \Auth::id();//Set for ReportQueue
    $this->params = $params;
    $this->exportParams = $exportParams;
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function query()
  {
    return OrderItem::orderBy('id', 'desc')->with(['order.customer']);

  }

  /**
   * Table headings
   *
   * @return string[]
   */
  public function headings(): array
  {
    return [
      'Orden ID',
      'Producto ID',
      'Producto SKU',
      'Estado',
      'Producto',
      'Cantidad',
      'Valor Und.',
      'Total',
      'Cliente',
      'Teléfono',
      'Correo',
      'Método de Envío',
      'Método de Pago',
      'Creado en',
      'Actualizado en',
    ];
  }

  /**
   * @var Invoice $invoice
   */
  public function map($item): array
  {
    //Order Transform
    $order = json_decode(json_encode(new OrderTransformer($item->order)));
    //Map data
    return [
      $item->order_id ?? null,
      $item->product_id ?? null,
      $item->reference ?? null,
      $order->statusName ?? null,
      $item->title ?? null,
      $item->quantity ?? null,
      $item->price ?? null,
      $item->total ?? null,
      $order->customer->fullName ?? null,
      $item->telephone ?? $item->order->shipping_telephone ?? $item->order->payment_telephone ?? null,
      $order->customer->email ?? null,
      $order->shippingMethod ?? null,
      $order->paymentMethod ?? null,
      $item->created_at ?? null,
      $item->updated_at ?? null,
    ];
  }

  /**
   * //Handling Events
   *
   * @return array
   */
  public function registerEvents(): array
  {
    return [
      // Event gets raised at the start of the process.
      BeforeExport::class => function (BeforeExport $event) {
        $this->lockReport($this->exportParams->exportName);
      },
      // Event gets raised before the download/store starts.
      BeforeWriting::class => function (BeforeWriting $event) {
      },
      // Event gets raised just after the sheet is created.
      BeforeSheet::class => function (BeforeSheet $event) {
      },
      // Event gets raised at the end of the sheet process
      AfterSheet::class => function (AfterSheet $event) {
        $this->unlockReport($this->exportParams->exportName);
        //Send pusher notification
        app('Modules\Notification\Services\Inotification')->to(['broadcast' => $this->params->user->id])->push([
          "title" => "New report",
          "message" => "Your report is ready!",
          "link" => url(''),
          "isAction" => true,
          "frontEvent" => [
            "name" => "isite.export.ready",
            "data" => $this->exportParams
          ],
          "setting" => ["saveInDatabase" => 1]
        ]);
      },
    ];
  }
}
