<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/icommerce')->group(function (Router $router) {
    $router->get('store/', [
        'as' => 'admin.icommerce.store.index',
        'uses' => 'ProductController@index',
        'middleware' => 'can:icommerce.products.index',
    ]);
    Route::prefix('bulkload')->group(function (Router $router) {
        $router->get('index', [
            'as' => 'admin.icommerce.bulkload.index',
            'uses' => 'ProductController@indeximport',
            'middleware' => 'can:icommerce.bulkload.import',
        ]);
        $router->get('export', [
            'as' => 'admin.get.icommerce.bulkload.export',
            'uses' => 'ProductController@indexexport',
            'middleware' => 'can:icommerce.bulkload.export',
        ]);
        $router->post('import', [
            'as' => 'admin.icommerce.bulkload.import',
            'uses' => 'ProductController@importProducts',
            'middleware' => 'can:icommerce.bulkload.import',
        ]);
        $router->post('export', [
            'as' => 'admin.post.icommerce.bulkload.export',
            'uses' => 'ProductController@exportProducts',
            'middleware' => 'can:icommerce.bulkload.export',
        ]);
    });
});
