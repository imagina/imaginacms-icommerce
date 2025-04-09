<?php

namespace Modules\Icommerce\Exports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

//Events
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;


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
    $userId = $this->userId;
    $indexAll = $this->params->permissions['icommerce.orders.index-all'] ?? false;

    $query = \DB::table('icommerce__order_item as oi')
      ->select(
        'oi.order_id',
        'oi.product_id',
        'oi.reference as product_sku',
        'ot.title as order_status',
        'oi.title as product_title',
        'oi.quantity',
        'oi.price',
        'oi.total',
        \DB::raw("CONCAT(u.first_name, ' ', u.last_name) as customer_full_name"),
        \DB::raw("COALESCE(o.telephone, o.shipping_telephone, o.payment_telephone) as telephone"),
        'u.email as customer_email',
        'o.shipping_method',
        'o.payment_method',
        'oi.created_at',
        'oi.updated_at'
      )
      ->join('icommerce__orders as o', 'oi.order_id', '=', 'o.id')
      ->join('icommerce__order_status_trans as ot', function($join) {
        $join->on('o.status_id', '=', 'ot.order_status_id')
          ->where('ot.locale', app()->getLocale()); // Use current app locale
      })
      ->join('users as u', 'o.customer_id', '=', 'u.id')
      ->orderBy('oi.id', 'desc');

    // Filter orders for the logged-in user if 'index-all' permission is not granted
    if (!$indexAll) {
      $query->where('o.customer_id', $userId);
    }

    return $query;
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
   * @var Invoice
   */
  public function map($item): array
  {
    //Map data
    return [
      $item->order_id ?? null,
      $item->product_id ?? null,
      $item->product_sku ?? null,
      $item->order_status ?? null,
      $item->product_title ?? null,
      $item->quantity ?? null,
      $item->price ?? null,
      $item->total ?? null,
      $item->customer_full_name ?? null,
      $item->telephone ?? null,
      $item->customer_email ?? null,
      $item->shipping_method ?? null,
      $item->payment_method ?? null,
      $item->created_at ?? null,
      $item->updated_at ?? null,
    ];
  }

  /**
   * //Handling Events
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
         app('Modules\Notification\Services\Inotification')->to([
          "email" => $this->params->user->email,
          'broadcast' => $this->params->user->id
        ])->push([
          "title" => trans('icommerce::common.export.ordersExportTitle'),
          "message" => trans('icommerce::common.export.ordersExportDescription'),
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

  public function failed(Throwable $exception)
  {
    $this->unlockReport($this->exportParams->exportName);
    \Log::error("Export failed: " . $exception->getMessage());

    app('Modules\Notification\Services\Inotification')->to([
      "email" => $this->params->user->email,
      'broadcast' => $this->params->user->id
    ])->push([
      "title" => trans('icommerce::common.export.ordersExportFailedTitle'),
      "message" => trans('icommerce::common.export.ordersExportFailedDescription'),
      "link" => url(''),
      "isAction" => true,
      "frontEvent" => [
        "name" => "isite.export.failed",
        "data" => $this->exportParams
      ],
      "setting" => ["saveInDatabase" => 1]
    ]);
  }
}
