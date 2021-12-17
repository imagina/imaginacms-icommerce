<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/orders'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.icommerce.orders.create',
    'uses' => 'OrderApiController@create',
    'middleware' => ['auth:api','can:icommerce.orders.create']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.icommerce.orders.index',
    'uses' => 'OrderApiController@index',
    'middleware' => ['auth:api','can:icommerce.orders.index']
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.icommerce.orders.update',
    'uses' => 'OrderApiController@update',
    'middleware' => ['auth:api','can:icommerce.orders.edit']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.icommerce.orders.delete',
    'uses' => 'OrderApiController@delete',
    'middleware' => ['auth:api','can:icommerce.orders.destroy']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.icommerce.orders.show',
    'uses' => 'OrderApiController@show',
    //'middleware' => ['auth:api']
  ]);


  // Ruta de Prueba
  $router->get('/test/pusher', function () {

    $order = app('Modules\Icommerce\Repositories\OrderRepository')->find(3);
    $cart = app('Modules\Icommerce\Repositories\CartRepository')->find(17);

    // Data Order Items
    $supportOrderItem = new \Modules\Icommerce\Support\OrderItem();
    $dataOrderItem = $supportOrderItem->fixData($cart->products);

    event(new Modules\Icommerce\Events\OrderWasCreated($order,$dataOrderItem));

    return "Event has been sent!";

  });

});
